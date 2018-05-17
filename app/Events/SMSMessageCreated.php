<?php

namespace App\Events;

use App\Models\SmsMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SMSMessageCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	/**
	 * @var SmsMessage
	 */
	public $smsMessage;

	/**
	 * Create a new event instance.
	 *
	 * @param SmsMessage $smsMessage
	 */
    public function __construct(SmsMessage $smsMessage)
    {
	    $this->smsMessage = $smsMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('');
    }
}
