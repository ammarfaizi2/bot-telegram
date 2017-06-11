<?php

namespace Telegram;

class Telegram
{
	const USERAGENT = "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:46.0) Gecko/20100101 Firefox/46.0";
	/**
	 * @var int
	 */
	public $curl_errno;
	
	/**
	 * @var string
	 */
	public $curl_error;

	/**
	 * @var array
	 */
	public $curl_info;

	/**
	 * @var string
	 */
	private $bot_url;

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

	/**
	 *
	 * Send a text message.
	 *
	 * @param	string	$text
	 * @param	string	$to
	 * @param	string	$reply_to
	 * @return	string
	 */
	public function send_message(string $text, string $to, string $reply_to = null)
	{
	}



	private function execute(string $url, $post = null, array $option = null)
	{
		$ch = curl_init($url);
		$op = [
			CURLOPT_RETURNTRANSFER	=>	true,
			CURLOPT_SSL_VERIFYPEER	=>	false,
			CURLOPT_SSL_VERIFYHOST	=>	false,
			CURLOPT_FOLLOWLOCATION	=>	true,
			CURLOPT_USERAGENT		=>	self::USERAGENT,
		];
		if ($post !== null) {
			$op[CURLOPT_POST] 		= true;
			$op[CURLOPT_POSTFIELDS] = $post;
		}
		if (is_array($option)) {
			foreach ($option as $key => $value) {
				$op[$key] = $value;
			}
		}
		curl_setopt_array($ch, $op);
		$out = curl_exec($ch);
		$this->curl_errno = curl_errno($ch);
		$this->curl_error = curl_error($ch);
		$this->curl_info  = curl_getinfo($ch);
		return $this->curl_error ? $this->curl_error : $out;
	}
}