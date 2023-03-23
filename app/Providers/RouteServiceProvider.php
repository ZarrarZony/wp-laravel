<?php
namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
    $request = \Request();
    $domain = $request->server('HTTP_HOST');
    if($domain == 'localhost'){
      $path = public_path();
      $path = explode('\\', $path);
      $path = $path[3];
      $path = str_replace('\\', '/',$path);
      $path = $domain.$path;
      $path = 'http://'.$path;
    }
        config([
        'app.url'                      => $domain,
        "app.admin.url"                => $domain,
        'app.admin.app_path'           => app_path(),
      ]);
    $setConfiGuration = setConfiGuration($domain);
    if($setConfiGuration != "config set success") die("no site found against this url");
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
