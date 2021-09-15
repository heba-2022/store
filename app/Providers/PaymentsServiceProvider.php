<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PaymentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('paypal.client', function () {

            $config  = config('services.paypal');
            $mode = $config['mode'];
            $clientId =  $config['PAYPAL_CLIENT_I'];
            $clientSecret =  $config['PAYPAL_CLIENT_SECRET'];

            if ($mode == 'sandbox') {
                $environment = new SandboxEnvironment($clientId, $clientSecret);
            } else {
                $environment = new ProductionEnvironment($clientId, $clientSecret);
            }
            $client = new PayPalHttpClient($environment);
            return  $client;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
