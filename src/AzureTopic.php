<?php
namespace Goavega\LaravelAzureServicebus;

use WindowsAzure\ServiceBus\Models\BrokeredMessage;
use WindowsAzure\ServiceBus\Models\ReceiveMessageOptions;
use WindowsAzure\ServiceBus\Models\SubscriptionInfo;

class AzureTopic extends ServiceBus
{
    const SUBCRIPTION_NAME = '6c7dd8f3e3e145a5b9782b41d741c951';
    private $subscription;

    private function getSubscription(): string 
    {
        return $this->subscription ?? self::SUBCRIPTION_NAME;
    }

    protected function sendInternal(string $queue, BrokeredMessage $message): void
    {
        $this->azure->sendTopicMessage($queue, $message);
    }

    protected function receiveInternal(string $queue, ReceiveMessageOptions $receiveOptions): ?BrokeredMessage
    {
        //we don't create the subscription yet, it should be created manually for now.
        return $this->azure->receiveSubscriptionMessage($queue, $this->getSubscription(), $receiveOptions);
    }

    protected function ensureSubscription(string $queue)
    {
        // Create subscription.
        $subscriptionInfo = new SubscriptionInfo($this->getSubscription());
        $this->azure->createSubscription($queue, $subscriptionInfo);
    }
}
