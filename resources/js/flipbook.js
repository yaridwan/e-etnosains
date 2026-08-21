import * as pdfjsLib from 'pdfjs-dist';
import PdfWorkerUrl from 'pdfjs-dist/build/pdf.worker.min.mjs?url';
import { PageFlip } from 'page-flip';

pdfjsLib.GlobalWorkerOptions.workerSrc = PdfWorkerUrl;

async function renderHalamanKeCanvas(pdf, nomorHalaman, skala) {
    const halaman = await pdf.getPage(nomorHalaman);
    const viewport = halaman.getViewport({ scale: skala });

    const canvas = document.createElement('canvas');
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    canvas.className = 'h-full w-full object-contain bg-white';

    const konteks = canvas.getContext('2d');
    await halaman.render({ canvasContext: konteks, viewport }).promise;

    return canvas;
}

function bungkusHalaman(canvas) {
    const bungkus = document.createElement('div');
    bungkus.className = 'flipbook-halaman bg-white shadow-inner';
    bungkus.appendChild(canvas);

    return bungkus;
}

export async function inisialisasiFlipbook({
    elemenContainer,
    urlPdf,
    elemenStatus,
    elemenNomorHalaman,
    elemenTotalHalaman,
    tombolSebelumnya,
    tombolBerikutnya,
    tombolZoomMasuk,
    tombolZoomKeluar,
    tombolLayarPenuh,
}) {
    if (!elemenContainer) return;

    const isMobile = window.matchMedia('(max-width: 767px)').matches;

    try {
        const tugas = pdfjsLib.getDocument({ url: urlPdf });
        const pdf = await tugas.promise;
        const jumlahHalaman = pdf.numPages;

        if (elemenTotalHalaman) elemenTotalHalaman.textContent = jumlahHalaman;
        if (elemenStatus) elemenStatus.remove();

        const skala = isMobile ? 1.1 : 1.4;
        const elemenHalaman = [];

        for (let i = 1; i <= jumlahHalaman; i++) {
            const canvas = await renderHalamanKeCanvas(pdf, i, skala);
            elemenHalaman.push(bungkusHalaman(canvas));
        }

        if (isMobile) {
            // Mode pembaca vertikal untuk perangkat mobile
            elemenContainer.classList.add('flex', 'flex-col', 'items-center', 'gap-3', 'overflow-y-auto');
            elemenHalaman.forEach((el) => elemenContainer.appendChild(el));
            if (elemenNomorHalaman) elemenNomorHalaman.textContent = '1';

            elemenContainer.addEventListener('scroll', () => {
                const tinggiPerHalaman = elemenContainer.scrollHeight / jumlahHalaman;
                const halamanSaatIni = Math.min(jumlahHalaman, Math.max(1, Math.round(elemenContainer.scrollTop / tinggiPerHalaman) + 1));
                if (elemenNomorHalaman) elemenNomorHalaman.textContent = halamanSaatIni;
            });

            tombolSebelumnya?.remove();
            tombolBerikutnya?.remove();

            return;
        }

        const canvasContoh = elemenHalaman[0].querySelector('canvas');

        const pageFlip = new PageFlip(elemenContainer, {
            width: canvasContoh.width,
            height: canvasContoh.height,
            size: 'fixed',
            maxShadowOpacity: 0.5,
            showCover: true,
            mobileScrollSupport: true,
            useMouseEvents: true,
        });

        pageFlip.loadFromHTML(elemenHalaman);

        if (elemenNomorHalaman) elemenNomorHalaman.textContent = '1';

        pageFlip.on('flip', (e) => {
            if (elemenNomorHalaman) elemenNomorHalaman.textContent = e.data + 1;
        });

        tombolSebelumnya?.addEventListener('click', () => pageFlip.flipPrev());
        tombolBerikutnya?.addEventListener('click', () => pageFlip.flipNext());

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') pageFlip.flipPrev();
            if (e.key === 'ArrowRight') pageFlip.flipNext();
        });

        let skalaZoom = 1;
        const terapkanZoom = () => {
            elemenContainer.style.transform = `scale(${skalaZoom})`;
            elemenContainer.style.transformOrigin = 'top center';
        };
        tombolZoomMasuk?.addEventListener('click', () => {
            skalaZoom = Math.min(2, skalaZoom + 0.15);
            terapkanZoom();
        });
        tombolZoomKeluar?.addEventListener('click', () => {
            skalaZoom = Math.max(0.6, skalaZoom - 0.15);
            terapkanZoom();
        });

        tombolLayarPenuh?.addEventListener('click', () => {
            const target = elemenContainer.closest('[data-flipbook-bingkai]') || elemenContainer;
            if (!document.fullscreenElement) {
                target.requestFullscreen?.();
            } else {
                document.exitFullscreen?.();
            }
        });
    } catch (error) {
        console.error('Gagal memuat flipbook:', error);
        if (elemenStatus) {
            elemenStatus.textContent = 'Gagal memuat berkas PDF. Silakan coba muat ulang halaman.';
            elemenStatus.classList.add('text-rose-600');
        }
    }
}

window.inisialisasiFlipbook = inisialisasiFlipbook;
