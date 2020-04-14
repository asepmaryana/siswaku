<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class SiswakuAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $halaman    = '';
        if(Request::segment(1) == 'siswa') $halaman = 'siswa';
        elseif(Request::segment(1) == 'about') $halaman = 'about';
        elseif(Request::segment(1) == 'kelas') $halaman = 'kelas';
        elseif(Request::segment(1) == 'hobi') $halaman = 'hobi';
        elseif(Request::segment(1) == 'user') $halaman = 'user';
        view()->share('halaman', $halaman);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
