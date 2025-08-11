<?php

namespace App\Providers;

use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
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
//        FilamentAsset::register([
//            Js::make('tesseract', 'https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/5.0.2/tesseract.min.js'),
//        ]);
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalHeading('Switch Aplikasi')
                ->labels([
                    'pelayanan_jenis' => 'Pelayanan Jenis Ikan',
                    'pegawai' => 'Blog / Publikasi'
                ])
                ->icons([
                    'pelayanan_jenis' => 'phosphor-fish-simple-fill',
                    'pegawai' => 'heroicon-s-globe-asia-australia',
                ], $asImage = false)
                ->slideOver()
                ->modalWidth('sm')
                ->simple();
        });
    }
}
