<?php

namespace Bot\Commands;

use Bot\Client;
use GuzzleHttp\Client as Http;
use TelegramBot\Api\Types\Message;

/**
 * Class Git
 * @package Bot\Commands
 */
class Git extends Command
{
    /**
     * Command handler.
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     * @return void
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $repo   = $args[0] ?: null;
        $author = $args[1] ?: null;

        if (!$args) {
            $text = "Usage: /git <repository> <author>";
        } else {
            $query = ($author ? "user:{$author} " : "") . "{$repo}";

            $http = new Http([
                'base_uri'  => 'https://api.github.com/',

                'timeout'   => 2.0
            ]);

            $response = $http->request('GET', 'search/repositories', [
                'query' => [
                    'q'     => $query
                ],

                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                // Parse the json returned by the GitHub Search API
                $input 	= json_decode($response->getBody(), true);

                if (isset($input["total_count"])) {
                    // Are there any results?
                    if ($input["total_count"] === 0) {
                        $text = "No github repositories found with: {$query}";
                    } else {
                        // Always return the first result from the array
                        $text = "Showing top result: \r\n" .
                            "User: " . $input["items"][0]["owner"]["login"] . "\r\n" .
                            "Repo: " . $input["items"][0]["name"] . "\r\n" .
                            $input["items"][0]["html_url"];
                    }
                } else {
                    $text = "Error retrieving git data, please try again later";
                }
            } else {
                $text = "Failed to get data from github API";
            }
        }

        $bot->sendMessage($message->getChat()->getId(), $text);
    }
}
