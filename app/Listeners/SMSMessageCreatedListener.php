<?php

namespace App\Listeners;

use anlutro\BulkSms\BulkSmsService;
use App\Events\SMSMessageCreated;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SimpleSoftwareIO\SMS\Facades\SMS;

class SMSMessageCreatedListener {
	/**
	 * Create the event listener.
	 *
	 */
	public function __construct() {
	}

	/**
	 * Handle the event.
	 *
	 * @param  SMSMessageCreated $event
	 *
	 * @return void
	 */
	public function handle( SMSMessageCreated $event ) {
		$number = str_replace('+', '0', $event->smsMessage->number);
		if ( Settings::get( 'sms_driver' ) == 'msg91' ) {
			$this->sendMsg91SMS( $number, $event->smsMessage->text );
		} elseif ( Settings::get( 'sms_driver' ) == 'bulk_sms' ) {
			$bulkSms = new BulkSmsService( config( 'bulk-sms.username' ), config( 'bulk-sms.password' ), config( 'bulk-sms.baseurl' ) );
			$bulkSms->sendMessage( str_replace( '+91', '',$number ), $event->smsMessage->text );
		} else {
			SMS::send( $event->smsMessage->text, [], function ( $sms ) use ( $number ) {
				$sms->to( $number );
			} );
		}
	}

	private function sendMsg91SMS( $number, $message ) {
		$postData = array(
			'authkey' => Settings::get( 'msg91_auth_key' ),
			'mobiles' => $number,
			'message' => urlencode($message),
			'sender' => Settings::get( 'msg91_sender_id' ),
			'route' => 4
		);
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => "https://control.msg91.com/api/sendhttp.php",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec($ch);
		curl_close($ch);
	}
}
