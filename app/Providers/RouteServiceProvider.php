<?php

namespace App\Providers;

use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\ApiRateLimitMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the superadmin middleware
        $this->app['router']->aliasMiddleware('superadmin', SuperAdmin::class);
        
        // Register API middleware
        $this->app['router']->aliasMiddleware('api.auth', ApiAuthMiddleware::class);
        $this->app['router']->aliasMiddleware('superadmin.api', SuperAdminMiddleware::class);
        $this->app['router']->aliasMiddleware('api.throttle', ApiRateLimitMiddleware::class);
        
        // Load web routes
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        
        // Load API routes
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
