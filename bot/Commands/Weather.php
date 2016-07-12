<?php

namespace Bot\Commands;

use Bot\Client;
use GuzzleHttp\Client as Http;
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
            $http = new Http([
                'base_uri'  => 'http://api.openweathermap.org/',

                'timeout'   => 2.0
            ]);

            $response = $http->request('GET', 'data/2.5/weather', [
                'query' => [
                    'q'     => $location,
                    'APPID' => env('OWM_API')
                ]
            ]);

            // Parse the json returned by the OpenWeatherMap API
			$input 	= json_decode($response->getBody(), true);

			// Has the location been found by the OpenWeatherMap API
			if ($response->getStatusCode() === 200) {
                if ($input["cod"] !== 200) {
    				$text = "No weather data found for this location: " . ucfirst($location);
                } else {
					$text = "City: " . $input['name'] . ", " . $input['sys']['country'] . "\n" .
						    "Temperature: " . round($input["main"]["temp"] - 272.15, 1) . " °C \n" .
						    "Weather: " . $input["weather"][0]["main"] . " " . $this->emoji[(rtrim($input["weather"][0]["icon"], "nd"))];
			    }
            } else {
				$text = "Error retrieving weather data from API";
            }
		}

        $bot->sendMessage($message->getChat()->getId(), $text);
    }

}
