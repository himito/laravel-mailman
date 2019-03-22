<?php

namespace himito\mailman;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class MailmanServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mailman.php', 'mailman');

        // Register the service the package provides.
        $this->app->singleton('mailman', function ($app) {
            $config = config('mailman');

            $base_uri = "{$config['host']}:{$config['port']}/{$config['api']}/";
            $auth = [$config['admin_user'], $config['admin_pass']];

            $client = new Client(compact('base_uri', 'auth'));
            return new Mailman($client);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['mailman'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/mailman.php' => config_path('mailman.php'),
        ], 'mailman.config');
    }
}
