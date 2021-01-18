<?php

namespace App\Providers;

use App\Models\PaymentDetail;
use App\Models\User;
use App\Service\Interfaces\PaymentDataRegistratorInterface;
use App\Service\Interfaces\UserRegistratorInterface;
use App\Service\PaymentDataRegistrator;
use App\Service\UserRegistrator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRegistratorInterface::class, function ($app) {
            return new UserRegistrator($app->get(User::class));
        });

        $this->app->bind(ClientInterface::class, function($app) {
            return new Client($app['config']['payment_data_client']);
        });

        $this->app->bind(PaymentDataRegistratorInterface::class, function ($app) {
            return new PaymentDataRegistrator(
                $app->get(PaymentDetail::class),
                $app->get(ClientInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            UserRegistratorInterface::class,
            PaymentDataRegistratorInterface::class
        ];
    }
}
