<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditAktivitasController extends Controller
{
    public function index(Request $request): View
    {
        $query = AuditAktivitas::with('pengguna');

        if ($request->filled('q')) {
            $kataKunci = $request->string('q');
            $query->where(fn ($q) => $q
                ->where('aktivitas', 'like', "%{$kataKunci}%")
                ->orWhereHas('pengguna', fn ($p) => $p->where('nama_lengkap', 'like', "%{$kataKunci}%")));
        }

        if ($request->filled('modul')) {
            $query->where('modul', $request->string('modul'));
        }

        if ($request->filled('dari')) {
            $query->whereDate('dibuat_pada', '>=', $request->date('dari'));
        }

        if ($request->filled('sampai')) {
            $query->whereDate('dibuat_pada', '<=', $request->date('sampai'));
        }

        return view('admin.audit-aktivitas.index', [
            'audit' => $query->latest('dibuat_pada')->paginate(25)->withQueryString(),
            'daftarModul' => AuditAktivitas::query()->distinct()->orderBy('modul')->pluck('modul', 'modul'),
        ]);
    }
}
