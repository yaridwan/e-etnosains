<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Menerbitkan E-Modul terjadwal setiap menit agar tampil tepat waktu di
// portal publik. Jalankan `php artisan schedule:work` (atau daftarkan
// `php artisan schedule:run` pada cron setiap menit) di server produksi.
Schedule::command('e-modul:terbitkan-terjadwal')->everyMinute()->withoutOverlapping();
