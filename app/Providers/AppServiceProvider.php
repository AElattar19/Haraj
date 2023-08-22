<?php

namespace App\Providers;

use App\Support\Sidebar\Sidebar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Language\Models\Language;

class AppServiceProvider extends ServiceProvider
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
        Schema::defaultStringLength(120);

        $this->viewComposers();

        $this->loadviews();
        //$this->loadJsonTranslations();
        $this->loadMigration();
    }

    private function viewComposers()
    {
        View::composer('dashboard.layouts.default', function (\Illuminate\View\View $view) {
            $view->with('sidebar', (new Sidebar())());
        });
        if (\Schema::hasTable('migrations') && \Schema::hasTable('languages')) {
            $allLanguages = Language::active()->get();
            View::composer('components.navbar.navbar', function ($view) use ($allLanguages) {

                $languages = $allLanguages->where('code', '<>', get_current_lang());
                $current = $allLanguages->where('code', get_current_lang())->first();
                $view->with(['current' => $current, 'languages' => $languages]);
            });
            $info = setting('info');

            View::share(['languages' => $allLanguages, 'info'=>$info]);
        }
    }

    private function loadviews()
    {
        $modules_glob = glob(app_path().'/Modules/**/resources/views');

        foreach ($modules_glob as $value) {

            $str = explode('/', substr($value, strpos($value, 'Modules')));

            $this->loadViewsFrom($value, $str[1]);
        }
    }

    private function loadMigration()
    {
        $migration_glob = glob(app_path().'/Modules/**/database/migrations/*.php');
        foreach ($migration_glob as $file) {
            $file = edit_separator($file);
            $this->loadMigrationsFrom($file);
        }
    }
}
