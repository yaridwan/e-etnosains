<?php

namespace App\Providers;

use App\Models\BahanAjar;
use App\Models\EModul;
use App\Models\Lkpd;
use App\Models\Observasi;
use App\Models\Poster;
use App\Models\VideoPembelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Model::unguard(false);

        Blueprint::macro('waktuStandar', function () {
            /** @var Blueprint $this */
            $this->timestamp('dibuat_pada')->nullable();
            $this->timestamp('diperbarui_pada')->nullable();
        });

        Blueprint::macro('hapusLunak', function () {
            /** @var Blueprint $this */
            $this->softDeletes('dihapus_pada');
        });

        Relation::enforceMorphMap([
            'e_modul' => EModul::class,
            'lkpd' => Lkpd::class,
            'bahan_ajar' => BahanAjar::class,
            'video_pembelajaran' => VideoPembelajaran::class,
            'poster' => Poster::class,
            'observasi' => Observasi::class,
        ]);

        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
