Windows Azure Servicebus Queue driver for Laravel
=================================================
### Overview
The library provides support for both Service Bus queues and topic based messaging (topics haven't been tested yet on 5.x branch but should work). Default is Service Bus queues, for topic based messaging UseTopic should be set to true. The package should be auto discovered on Laravel > 5.6

[![Latest Stable Version](https://poser.pugx.org/goavega-software/laravel-azure-servicebus/v/stable)](https://packagist.org/packages/goavega-software/laravel-azure-servicebus)
[![Total Downloads](https://poser.pugx.org/goavega-software/laravel-azure-servicebus/downloads)](https://packagist.org/packages/goavega-software/laravel-azure-servicebus)
[![License](https://poser.pugx.org/goavega-software/laravel-azure-servicebus/license)](https://packagist.org/packages/goavega-software/laravel-azure-servicebus)
#### Installation

Require this package in your `composer.json`:

	"goavega-software/laravel-azure-servicebus": "<<version>>"

Run composer update!

After composer update is finished you need to add ServiceProvider to your `providers` array in `app/config/app.php`:

	'Goavega\LaravelAzureServicebusTopic\Support\Serviceprovider',

add the following to the `connection` array in `app/config/queue.php`, and fill out your own connection data from the Azure Management portal:

	'azureservicebus' => array(
        'driver'       => 'azureservicebus',
        'endpoint'     => 'https://*.servicebus.windows.net',
        'SharedAccessKeyName' => '',
        'SharedAccessKey' => 'primary key',
        'queue'        => '<topic name>',
        'UseTopic' => true/false (default false)
    )

#### Usage
The library provides support for both Service Bus queues and topic based messaging. Default is Service Bus queues, for topic based messaging UseTopic should be set to true.
Once you completed the configuration you can use Laravel Queue API. If you do not know how to use Queue API, please refer to the official Laravel [documentation](http://laravel.com/docs/queues).

From laravel Queue documentation, something like this should work:
```php
        $payload = new \stdClass();
        $payload->id = 1;
        $payload->name = 'hello world';
        ProcessPodcast::dispatch($payload)->onConnection('azureservicebus')->onQueue('queue-name');
```
artisan worker should be started as per Laravel's official documentation:

```shell
php artisan queue:listen azureservicebus --queue=queue-name
```
### Azure Topic Support
There is no support (yet) of automatically creating subscriptions on the Azure Topic. A known subscription identifier is instead used for the subscription and needs to be created manually on the service bus. The identifier is `6c7dd8f3e3e145a5b9782b41d741c951`

### Version compatiblity
* Use version 2.x if you are on Laravel 5.5
* Use version 5.x if you are on Laravel 5.6-5.8
* Support for laravel 6.x is not tested (PRs welcome)
#### Contribution

You can contribute to this package by opening issues/pr's. Enjoy!

#### Attribution
Inspired by https://github.com/stayallive/laravel-azure-servicebus-queue
