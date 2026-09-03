<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $query = Faq::query();

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q->where('pertanyaan', 'like', "%{$kataKunci}%")->orWhere('jawaban', 'like', "%{$kataKunci}%"));
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->string('status') === 'aktif');
        }

        return view('admin.website.faq', [
            'data' => $query->orderBy('urutan')->paginate(15)->withQueryString(),
        ]);
    }

    private function aturan(): array
    {
        return [
            'pertanyaan' => ['required', 'string', 'max:255'],
            'jawaban' => ['required', 'string'],
            'urutan' => ['nullable', 'integer'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        Faq::create($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif', true)]);

        return back()->with('status', 'FAQ berhasil ditambahkan.');
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validate($this->aturan()) + ['aktif' => $request->boolean('aktif')]);

        return back()->with('status', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('status', 'FAQ berhasil dihapus.');
    }
}
