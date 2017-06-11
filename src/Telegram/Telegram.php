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
	 * @param	int		$reply_to
	 * @param	string	$parse_mode
	 * @return	string
	 */
	public function sendMessage(string $text, string $to, int $reply_to = null, string $parse_mode = "HTML")
	{
		$post = [
			"chat_id"		=> $to,
			"text"			=> $tetx,
			"parse_mode"	=> $parse_mode
		];
		if ($reply_to) {
			$post["reply_to_message_id"]
		}
		return $this->execute($this->bot_url."sendMessage", $post, []);
	}


	/**
	 *
	 * Execute.
	 *
	 * @param	string			$url
	 * @param	string|array	$post
	 * @param	array			$option
	 * @return	string
	 */
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