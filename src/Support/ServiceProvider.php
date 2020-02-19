<?php
namespace Goavega\LaravelAzureServicebus\Support;

use Goavega\LaravelAzureServicebus\AzureConnector;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $manager = $this->app['queue'];
        $manager->addConnector('azureservicebus', function () {
            return new AzureConnector();
        });
    }

    public function provides()
    {
        return ['azureservicebus'];
    }
}
