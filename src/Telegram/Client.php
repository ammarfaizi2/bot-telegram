<?php

namespace Telegram\Bot;

class Client
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
    protected static $break;

    /**
     *
     * Constructor.
     *
     * @param	string	$token
     */
    public function __construct(string $token)
    {
        self::__setBreakpoints();
        $this->bot_url = "https://api.telegram.org/bot{$token}/";
        $this->webhook_input = json_decode(self::getInput(), true);
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
            "chat_id" => $to,
            "text" => $text,
            "parse_mode" => $parse_mode
        ];
        if ($reply_to) {
            $post["reply_to_message_id"] = $reply_to;
        }
        return $this->execute($this->bot_url . "sendMessage", $post, []);
    }
    /*
     * Send a document
     * @param string $caption
     * @param string $document
     * @param string $to
     * @param int $reply_to
     * @param string $parse_mode
     */

    public function sendDocument(string $caption, string $document, string $to, int $reply_to = null, string $parse_mode = 'HTML')
    {
        if (!filter_var($document, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
            $realpath = realpath($document);
            if (!$realpath) {
                throw new \Exception("Can't open {$realpath}", 404);
                return false;
            }
        }
        $post = [
            'chat_id' => $to,
            'document' => new CURLFile($document),
            'caption' => $caption,
            'parse_mode' => $parse_mode
        ];
        if ($reply_to) {
            $post['reply_to_message_id'] = $reply_to;
        }
        return $this->execute($this->bot_url . 'sendDocument', $post, []);
    }

    /**
     *
     * Send a photo.
     *
     * @param	string	$photo
     * @param	string 	$to
     * @param	string	$caption
     * @param	int		$reply_to
     * @return	string
     */
    public function sendPhoto(string $photo, string $to, string $caption = null, int $reply_to = null)
    {
        if (!filter_var($photo, FILTER_VALIDATE_URL)) {
            $realpath = realpath($photo);
            if (!$realpath) {
                throw new \Exception("File not found. File : {$photo}", 404);
                return false;
            }
            $photo = new CurlFile($realpath);
        }
        $post = [
            "chat_id" => $to,
            "photo" => $photo
        ];
        if ($reply_to) {
            $post["reply_to_message_id"] = $reply_to;
        }
        return $this->execute($this->bot_url . "sendPhoto", $post, []);
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
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => self::USERAGENT,
        ];
        if ($post !== null) {
            $op[CURLOPT_POST] = true;
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

    public static function getInput()
    {
        return file_get_contents("php://input");
    }

    public function __setBreakpoints()
    {
        self::$break = json_encode(debug_backtrace(), JSON_PRETTY_PRINT);
    }
    public function __getBreakpoints()
    {
        return self::$break;
    }
}
