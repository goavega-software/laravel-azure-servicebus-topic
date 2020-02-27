<?php
namespace Goavega\LaravelAzureServicebus;

use WindowsAzure\ServiceBus\Models\BrokeredMessage;
use WindowsAzure\ServiceBus\Models\ReceiveMessageOptions;

class AzureTopic extends ServiceBus
{
    protected function sendInternal(string $queue, BrokeredMessage $message): void
    {
        $this->azure->sendTopicMessage($queue, $message);
    }

    protected function receiveInternal(string $queue, ReceiveMessageOptions $receiveOptions): ?BrokeredMessage
    {
        return $this->azure->receiveQueueMessage($queue, $receiveOptions);
    }
}
