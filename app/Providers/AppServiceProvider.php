<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Support\Facades\Event;
use App\Providers\Socialite\SnapchatProvider;

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
        Event::listen(SocialiteWasCalled::class, function ($socialiteWasCalled) {
            $socialiteWasCalled->extendSocialite('snapchat', \SocialiteProviders\Snapchat\Provider::class);
        });

        Socialite::extend('snapchat', function ($app) {
            $config = $app['config']['services.snapchat'];
    
            return new SnapchatProvider(
                $app['request'],
                $config['client_id'],
                $config['client_secret'],
                $config['redirect']
            );
        });
    }
}
