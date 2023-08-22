<?php

namespace Modules\Language\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
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

        $ds = DIRECTORY_SEPARATOR;

        $ModuleName = 'Languages';

        config([
            $ModuleName => File::getRequire(__DIR__.$ds.'..'.$ds.'config'.$ds.'route.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.$ds.'..'.$ds.'routes'.$ds.'web.php');
        $this->loadViewsFrom(__DIR__.$ds.'..'.$ds.'resources'.$ds.'views', $ModuleName);
        $this->loadMigrationsFrom(__DIR__.$ds.'..'.$ds.'database'.$ds.'migrations');
        //        dd(config());

    }
}
