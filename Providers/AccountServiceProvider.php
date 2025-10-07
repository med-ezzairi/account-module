<?php

namespace Modules\Account\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Factory;
use Modules\Account\Contracts\Gate as GateContract;
use Modules\Account\Gates\Gate;

class AccountServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Account', 'Database/Migrations'));
        
        //-- custom Gate to manage Permissions
        $this->registerAccessGate();
        //-- register custom middlewares (defined inside this Module/package and will be used by the application)
        $this->registerMiddlewares();
        
        $this->registerBladeDirectives();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Account', 'Config/config.php') => config_path('account.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Account', 'Config/config.php'), 'account'
        );
        $this->mergeConfigFrom(
            module_path('Account', 'Config/permissions.php'), 'account.permissions'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/account');

        $sourcePath = module_path('Account', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/account';
        }, \Config::get('view.paths')), [$sourcePath]), 'account');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/account');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'account');
        } else {
            $this->loadTranslationsFrom(module_path('Account', 'Resources/lang'), 'account');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Account', 'Database/factories'));
        }
    }
    
    
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new Gate($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });
    }
    
    /**
     * Regiter the Module/Package middlewares
     * 
     */
    protected function registerMiddlewares()
    {
        app('router')->aliasMiddleware('allowed', \Modules\Account\Http\Middleware\AuthorizeRequest::class);
    }
    
    /**
     * Regiter extra blade directives defined by this Module/Package
     * 
     */
    protected function registerBladeDirectives()
    {
        //-- add a custom directive: @allowed(ability)
        Blade::directive('allowed', function ($expression) {
            return "<?php if(allowed($expression)): ?>";
        });
        
        //-- add a closing tag to @allowed
        Blade::directive('endallowed', function ($expression) {
            return "<?php endif; ?>";
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
