<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimoniController extends Controller
{
    public function index(Request $request): View
    {
        $query = Testimoni::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('nama', 'like', "%{$kataKunci}%")->orWhere('isi_testimoni', 'like', "%{$kataKunci}%"));
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->string('status') === 'aktif');
        }

        return view('admin.website.testimoni', [
            'data' => $query->orderBy('urutan')->paginate(15)->withQueryString(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'peran_testimoni' => ['nullable', 'string', 'max:150'],
            'isi_testimoni' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'urutan' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        Testimoni::create($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif', true)]);

        return back()->with('status', 'Testimoni berhasil ditambahkan.');
    }

    public function update(Request $request, Testimoni $testimoni): RedirectResponse
    {
        $testimoni->update($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimoni $testimoni): RedirectResponse
    {
        $testimoni->delete();

        return back()->with('status', 'Testimoni berhasil dihapus.');
    }
}
