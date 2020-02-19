Windows Azure Servicebus Queue driver for Laravel
=================================================
### Overview
This package is alpha only and primarily used for queueing laravel events in Service Bus Topics. The primary advantage of using topic based events is that it can be consumed by multiple subscribers. artisan queue:listen is not supported (yet).
#### Installation

Require this package in your `composer.json`:

	"goavega-software/laravel-azure-servicebus": "1.2.1"

Run composer update!

After composer update is finished you need to add ServiceProvider to your `providers` array in `app/config/app.php`:

	'Goavega\LaravelAzureServicebusTopic\Support\Serviceprovider',

add the following to the `connection` array in `app/config/queue.php`, set your `default` connection to `azure` and fill out your own connection data from the Azure Management portal:

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
Once you completed the configuration you can use Laravel Queue API. If you used other queue drivers you do not need to change anything else. If you do not know how to use Queue API, please refer to the official Laravel [documentation](http://laravel.com/docs/queues).

### Version compatiblity
* Use version 2.x if you are on Laravel 5.5
* Use version 3.x if you are on Laravel 5.6-5.8
* Support for laravel 6.x is work in progress (PRs welcome)
#### Contribution

You can contribute to this package by opening issues/pr's. Enjoy!

#### Attribution
Inspired by https://github.com/stayallive/laravel-azure-servicebus-queue
