<?php

namespace App\Mail;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageMail extends Mailable {
	use Queueable, SerializesModels;
	/**
	 * @var array
	 */
	public $request;

	/**
	 * Create a new message instance.
	 *
	 * @param array $request
	 */
	public function __construct( $request = null ) {
		$this->request = $request;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->view( 'emails.contact' )
					->to(Settings::get('email'))
		            ->from( $this->request['email'] )
		            ->subject( trans( 'mailbox.new_message' ) );
	}
}
