<?php
namespace Goavega\LaravelAzureServicebusTopic\Support;

use Goavega\LaravelAzureServicebusTopic\AzureConnector;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
     * Register the service provider.
     *
     * @return void
     */
	public function register()
	{
		$this->app->booted(function () {
			$this->app->queue->extend('azure.servicebus', function () {
				return new AzureConnector;
			}
			);
		}
		);
	}
}
