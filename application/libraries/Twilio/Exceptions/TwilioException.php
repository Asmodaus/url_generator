<?php


namespace Twilio\Exceptions;


class TwilioException extends \Exception {
	public function __construct($err)
	{
		die($err);
	}
}