<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

class Weather extends Command
{

    /**
     * OpenWeatherMap icons for the weather
     *
     * @var array
     */
    private $emoji = [
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

    /**
     * Command handler.
     *
     * @param  Bot\Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $location = implode(" ", $args);

        if ($location === '') {
            $text = "Usage: /weather <location>";
        } else {
			$location = urlencode($location);

			// Create the url
			$url 	= "http://api.openweathermap.org/data/2.5/weather?q=" . $location . "&APPID=" . env('OWM_API');

            // Initialize curl
			$ch 	= curl_init();

            // Set the curl options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Run the query
			$input 	= curl_exec($ch);

            // Close the connection
			curl_close($ch);

            // Parse the json returned by the OpenWeatherMap API
			$input 	= json_decode($input, true);

			// Has the location been found by the OpenWeatherMap API
			if (isset($input["cod"])) {
                if ($input["cod"] !== 200) {
    				$text = "No weather data found for this location: " . ucfirst($location);
                } else {
					$text = "City: " . ucfirst($location) . "\n" .
						    "Temperature: " . round($input["main"]["temp"] - 272.15, 1) . " °C \n" .
						    "Weather: " . $input["weather"][0]["main"] . " " . $this->emoji[(rtrim($input["weather"][0]["icon"], "nd"))];
			    }
            } else {
				$text = "Error retrieving weather data, please try again later";
            }
		}

        $bot->sendMessage($message->getChat()->getId(), $text);
    }

}
