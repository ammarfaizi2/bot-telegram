<?php

namespace Telegram;

class Telegram
{

	/**
	 *
	 * Constructor.
	 *
	 * @param	string	$token
	 */
	public function __construct(string $token)
	{
		$this->bot_url = "https://api.telegram.org/bot{$token}/";
	}
}