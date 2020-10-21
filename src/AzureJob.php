<?php
namespace Goavega\LaravelAzureServicebus;

use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Queue\Jobs\Job;
use AzureServiceBus\ServiceBus\Internal\IServiceBus;
use AzureServiceBus\ServiceBus\Models\BrokeredMessage;

class AzureJob extends Job implements JobContract
{
    /**
     * The Azure IServiceBus instance.
     *
     * @var \AzureServiceBus\ServiceBus\Internal\IServiceBus
     */
    protected $azure;

    /**
     * The Azure ServiceBus job instance.
     *
     * @var \AzureServiceBus\ServiceBus\Models\BrokeredMessage
     */
    protected $job;

    /**
     * The queue that the job belongs to.
     *
     * @var string
     */
    protected $queue;

    /**
     * The raw payload on the queue.
     *
     * @var string
     */
    protected $rawMessage;
    /**
     * Create a new job instance.
     *
     * @param \Illuminate\Container\Container                 $container
     * @param \AzureServiceBus\ServiceBus\Internal\IServiceBus   $azure
     * @param \AzureServiceBus\ServiceBus\Models\BrokeredMessage $job
     * @param string                                          $queue
     *
     * @return \Goavega\LaravelAzureServicebusTopic\AzureJob
     */
    public function __construct(Container $container, IServiceBus $azure, BrokeredMessage $job, $queue, string $rawMessage)
    {
        $this->azure = $azure;
        $this->job = $job;
        $this->queue = $queue;
        $this->container = $container;
        $this->rawMessage = $rawMessage;
    }

    /**
     * Delete the job from the queue.
     */
    public function delete()
    {
        parent::delete();
        $this->azure->deleteMessage($this->job);
    }

    /**
     * Release the job back into the queue.
     *
     * @param int $delay
     */
    public function release($delay = 0)
    {
        $release = new \DateTime;
        $release->setTimezone(new \DateTimeZone('UTC'));
        $release->add(new \DateInterval('PT' . $delay . 'S'));
        $this->job->setScheduledEnqueueTimeUtc($release);
        $this->azure->unlockMessage($this->job);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return $this->job->getDeliveryCount();
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->job->getMessageId();
    }
    /**
     * Get the IoC container instance.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get the underlying Azure client instance.
     *
     * @return \AzureServiceBus\ServiceBus\Internal\IServiceBus
     */

    public function getAzure()
    {
        return $this->azure;
    }

    /**
     * Get the underlying raw Azure job.
     *
     * @return \AzureServiceBus\ServiceBus\Models\BrokeredMessage
     */

    public function getAzureJob()
    {
        return $this->job;
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->rawMessage;
    }
}
