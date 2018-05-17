<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use App\Mail\MessageMail;
use App\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageCreatedListener
{
	/**
	 * @var Mailer
	 */
	private $mailer;

	/**
	 * Create the event listener.
	 *
	 * @param Mailer $mailer
	 */
    public function __construct(Mailer $mailer)
    {
	    $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  MessageCreated  $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
    	$receiver = User::find($event->message->to);
	    $this->mailer->to( $receiver->email )->send( new MessageMail() );
    }
}
