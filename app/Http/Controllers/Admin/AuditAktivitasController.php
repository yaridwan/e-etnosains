<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditAktivitas;
use Illuminate\View\View;

class AuditAktivitasController extends Controller
{
    public function index(): View
    {
        return view('admin.audit-aktivitas.index', [
            'audit' => AuditAktivitas::with('pengguna')->latest('dibuat_pada')->paginate(25),
        ]);
    }
}
