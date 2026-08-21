<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\View\View;

class PosterController extends Controller
{
    public function index(): View
    {
        return view('publik.poster.index', [
            'poster' => Poster::dipublikasikan()->with('pengguna')->latest('dipublikasikan_pada')->paginate(12),
        ]);
    }
}
