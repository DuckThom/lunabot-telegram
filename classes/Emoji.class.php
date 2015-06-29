<?php

/*************************************
 * Class Emoji
 *
 * This class will be used to convert names/codes to Emoji's and stickers
 *************************************/
class Emoji {

	/**
	 * Return OpenWeatherMap icons as emoji
	 *
	 * @var string
	 * @return string
	 */
	public function getOWMEmoji($code = '')
	{
		$emojiCodes = [
				"01" => "\xE2\x98\x80", // Clear sky 
				"02" => "\xE2\x9B\x85", // Few clouds
				"03" => "\xE2\x98\x81", // Scattered clouds
				"04" => "\xE2\x98\x81", // Broken clouds
				"09" => "\xE2\x98\x94", // Shower rain
				"10" => "\xE2\x98\x94", // Rain
				"11" => "\xE2\x9A\xA1", // Thunderstorm
				"13" => "\xE2\x9B\x84", // Snow
				"50" => "\xE3\x80\xB0", // Mist
			];

		return (array_key_exists($code, $emojiCodes) ? $emojiCodes[$code] : '');
	}

	/**
	 * Return a sticker name as the sticker file_id
	 *
	 * @var string
	 * @return string
	 */
	public function getSticker($name = '')
	{
		$stickerList = [
				"doge" 	=> "BQADAgAD3gAD9HsZAAFphGBFqImfGAI", // Doge sticker
			];

		return (array_key_exists($name, $stickerList) ? $stickerList[$name] : '');
	}

}