<?php
namespace Goavega\LaravelAzureServicebusTopic;

use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use WindowsAzure\ServiceBus\Internal\IServiceBus;
use WindowsAzure\ServiceBus\Models\BrokeredMessage;
use WindowsAzure\ServiceBus\Models\ReceiveMessageOptions;

class AzureQueue extends Queue implements QueueContract
{
    /**
     * The Azure IServiceBus instance.
     *
     * @var \WindowsAzure\ServiceBus\Internal\IServiceBus
     */
    protected $azure;
    
    /**
     * The name of the default topic.
     *
     * @var string
     */
    protected $default;
    
    /**
     * Create a new Azure IQueue queue instance.
     *
     * @param \WindowsAzure\ServiceBus\Internal\IServiceBus $azure
     * @param string                                        $default
     *
     * @return \Goavega\LaravelAzureServicebusTopic\AzureQueue
     */
    public function __construct(IServiceBus $azure, $default)
    {
        $this->azure   = $azure;
        $this->default = $default;
    }

    public function size($queue = null)
    {
		return 0;
    }
    
    /**
     * Push a new job onto the queue.
     *
     * @param string $job
     * @param mixed  $data
     * @param string $queue
     */
    public function push($job, $data = '', $queue = null)
    {
        $this->pushRaw($this->createPayload($job, $data), $queue);
    }
    
    /**
     * Push a raw payload onto the queue.
     *
     * @param string $payload
     * @param string $queue
     * @param array  $options
     *
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = array())
    {
        $message = new BrokeredMessage($payload);
        $this->azure->sendTopicMessage($this->getQueue($queue), $message);
    }
    
    /**
     * Push a new job onto the queue after a delay.
     *
     * @param int    $delay
     * @param string $job
     * @param mixed  $data
     * @param string $queue
     */
    
    public function later($delay, $job, $data = '', $queue = null)
    {
        $payload = $this->createPayload($job, $data);
        $release = new \DateTime;
        $release->setTimezone(new \DateTimeZone('UTC'));
        $release->add(new \DateInterval('PT' . $delay . 'S'));
        $message = new BrokeredMessage($payload);
        $message->setScheduledEnqueueTimeUtc($release);
        $this->azure->sendTopicMessage($this->getQueue($queue), $message);
    }
    
    /**
     * Pop the next job off of the queue.
     *
     * @param string $queue
     *
     * @return \Illuminate\Queue\Jobs\Job|null
     */
    public function pop($queue = null)
    {
        return null;
    }
    
    /**
     * Get the queue or return the default.
     *
     * @param string|null $queue
     *
     * @return string
     */
    public function getQueue($queue)
    {
        return $queue ?: $this->default;
    }
    
    /**
     * Get the underlying Azure IQueue instance.
     *
     * @return \WindowsAzure\Queue\Internal\IQueue
     */
    public function getAzure()
    {
        return $this->azure;
    }
}
