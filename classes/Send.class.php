<?php

/*************************************
 * Class Send
 *
 * This class will be used to send messages
 *************************************/
class Send {

	/**
	 * Send the message to telegram
	 *
	 * @var $message - string
	 * @var $chatID  - int
	 * @var $key 	 - string
	 * @return boolean
	 */
	public function sendMessage($chatID, $text, $disable_web_page_preview = false, $reply_to_message_id = NULL)
	{
		$url 	= "https://api.telegram.org/bot" . BOT_KEY . "/sendMessage";	  
		
 		// POST data to send
		$fields = array(
						"chat_id" 					=> urlencode($chatID),
				  		"text" 						=> urlencode($text),
				  		"disable_web_page_preview"	=> (isset($disable_web_page_preview) ? urlencode($disable_web_page_preview)	: ''),
				  		"reply_to_message_id"		=> (isset($reply_to_message_id) 	 ? urlencode($reply_to_message_id) 		: '')
				  	);
		$fields_string = '';

		foreach($fields as $key => $value) { 
			$fields_string .= $key . '=' . $value . '&'; 
		}

		rtrim($fields_string, '&');

		$ch 	= curl_init();

		// Set curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Cast the return value to boolean
		$done  	= (bool) curl_exec($ch);

		curl_close($ch);

		unset($ch);

		return $done;
	}

	/**
	 * Send the sticker to telegram
	 *
	 * @var $message - string
	 * @var $chatID  - int
	 * @var $key 	 - string
	 * @return boolean
	 */
	public function sendSticker($chatID, $sticker, $reply_to_message_id = NULL)
	{
		$url 	= "https://api.telegram.org/bot" . BOT_KEY . "/sendSticker";	  
		
 		// POST data to send
		$fields = array(
						"chat_id" 				=> urlencode($chatID),
				  		"sticker" 				=> urlencode($sticker),
				  		"reply_to_message_id"	=> (isset($reply_to_message_id) ? urlencode($reply_to_message_id) : '')
				  	);
		$fields_string = '';

		foreach($fields as $key => $value) { 
			$fields_string .= $key . '=' . $value . '&'; 
		}

		rtrim($fields_string, '&');

		$ch 	= curl_init();

		// Set curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Cast the return value to boolean
		$done  	= (bool) curl_exec($ch);

		curl_close($ch);

		unset($ch);

		return $done;
	}
}

?>