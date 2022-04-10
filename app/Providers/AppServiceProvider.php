<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    protected $FrontOfficeApi = "App\Http\Controllers\Frontoffice";

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach(glob(base_path("routes/api/frontoffice/*.php")) as $file){
			Route::group([
				'namespace' => $this->FrontOfficeApi,
				'prefix' => 'api/frontoffice/',
				], function ($router) use($file) {
				require $file;
			});
		}
    }
}
