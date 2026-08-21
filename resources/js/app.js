import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

/**
 * Store tema dengan tiga pilihan: terang, gelap, dan mengikuti sistem.
 * Kelas .dark dipasang pada <html> sehingga varian dark: Tailwind aktif.
 */
Alpine.store('tema', {
    pilihan: localStorage.getItem('tema') || 'sistem',

    // Disimpan sebagai state reaktif, bukan getter yang membaca kelas DOM:
    // Alpine tidak dapat melacak perubahan classList sehingga ikon dan
    // penanda menu tidak akan ikut diperbarui.
    gelap: document.documentElement.classList.contains('dark'),

    init() {
        this.terapkan(false);

        // Ikuti perubahan preferensi sistem selama pengguna memilih "sistem".
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.pilihan === 'sistem') {
                this.terapkan();
            }
        });
    },

    pilih(nilai) {
        this.pilihan = nilai;
        localStorage.setItem('tema', nilai);
        this.terapkan();
    },

    /** Berpindah cepat antara terang dan gelap. */
    alihkan() {
        this.pilih(this.gelap ? 'terang' : 'gelap');
    },

    terapkan(denganTransisi = true) {
        const gelap =
            this.pilihan === 'gelap' ||
            (this.pilihan === 'sistem' && window.matchMedia('(prefers-color-scheme: dark)').matches);

        const akar = document.documentElement;

        if (denganTransisi) {
            akar.classList.add('tema-beralih');
            window.setTimeout(() => akar.classList.remove('tema-beralih'), 250);
        }

        akar.classList.toggle('dark', gelap);
        this.gelap = gelap;
    },
});

Alpine.start();
