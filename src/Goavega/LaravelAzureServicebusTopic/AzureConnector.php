<?php
namespace Goavega\LaravelAzureServicebusTopic;

use WindowsAzure\Common\ServicesBuilder;
use Illuminate\Queue\Connectors\ConnectorInterface;

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
		$connectionString = "Endpoint=$endpoint;SharedAccessKeyName=$sharedAccessName;SharedAccessKey=$sharedAccessKey";
		return new AzureQueue(
		ServicesBuilder::getInstance()->createServiceBusService($connectionString), $config['queue']);
	}
}
