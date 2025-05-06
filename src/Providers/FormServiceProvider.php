<?php
namespace Incodiy\Reactiform\Providers;

use Illuminate\Support\ServiceProvider;
use Incodiy\Reactiform\FormGenerator;

class FormServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('reactiform', function() {
            return new FormGenerator();
        });
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'reactiform');
        $this->loadViewComponentsAs('reactiform', [
            'Incodiy\Reactiform\View\Components\SelectComponent',
            'Incodiy\Reactiform\View\Components\TextComponent',
            'Incodiy\Reactiform\View\Components\TextareaComponent',
            'Incodiy\Reactiform\View\Components\CheckboxComponent',
            'Incodiy\Reactiform\View\Components\RadioComponent',
            'Incodiy\Reactiform\View\Components\ButtonComponent',
            'Incodiy\Reactiform\View\Components\FormOpenComponent',
            'Incodiy\Reactiform\View\Components\FormCloseComponent'
        ]);

        $this->publishes([
            __DIR__.'/../../config/reactiform.php' => config_path('reactiform.php'),
            __DIR__.'/../../resources/views' => resource_path('views/vendor/reactiform'),
            __DIR__.'/../../resources/js' => resource_path('js/vendor/reactiform'),
            __DIR__.'/../../resources/css/themes' => public_path('vendor/reactiform/themes'),
        ], 'reactiform');
    }
}