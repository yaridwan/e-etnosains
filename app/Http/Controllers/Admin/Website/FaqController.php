<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('admin.website.faq', ['data' => Faq::orderBy('urutan')->get()]);
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
