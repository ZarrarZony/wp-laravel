<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
       
        view()->composer(
          //for specific page  'templates.Modules.blog.module1',
            '*',
            'App\Http\View\Composers\MenuComposer'
        );
         view()->composer(
            '*',
            'App\Http\View\Composers\SiteinfoComposer'
        );
         view()->composer(
            '*',
            'App\Http\View\Composers\FooterComposer'
        );
        view()->composer(
            '*',
            'App\Http\View\Composers\SocialComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}