<?php
namespace Goavega\LaravelAzureServicebus;

use Illuminate\Queue\Connectors\ConnectorInterface;
use AzureServiceBus\Common\ServicesBuilder;

class AzureConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param array $config
     *
     * @return \Illuminate\Queue\QueueInterface
     */

    public function connect(array $config)
    {
        $endpoint = $config['endpoint'];
        $sharedAccessName = $config['SharedAccessKeyName'];
        $sharedAccessKey = $config['SharedAccessKey'];
        $shouldUseTopic = $config['UseTopic'] ?? false;
        $connectionString = "Endpoint=$endpoint;SharedAccessKeyName=$sharedAccessName;SharedAccessKey=$sharedAccessKey";
        $serviceBus = ServicesBuilder::getInstance()->createServiceBusService($connectionString);
        return $shouldUseTopic ? new AzureTopic($serviceBus, $config['queue']) :
        new AzureQueue($serviceBus, $config['queue']);
    }
}
