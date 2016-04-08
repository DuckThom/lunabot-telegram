<?php

/**
* Auto load the other classes when needed
*/
function _autoloader($class) {
    include "classes/" . $class . ".class.php";
}
spl_autoload_register('_autoloader');

class Bot {

    private $running;
    private $offset;
    public  $update;

    public function __construct()
    {
        /**
         * Set some variables
         */
        $this->running    = true;
        $this->config     = parse_ini_file('config/bot-config.ini');
        $this->offset     = 0;
        $this->lastUpdate = [];

        // Telegram Bot API key
        define('BOT_KEY', $this->config["key"]);
        // OpenWeatherMap API Key
        define('OWM_KEY', $this->config["owm_key"]);
        // Halo API Key
        define("HALO_KEY", $this->config["halo_key"]);
        // Debugging mode
        define( 'DEBUG' , $this->config["debug"]);
        // Anti flooding, timeout in seconds
        define('MSG_TIMEOUT', (int) $this->config["msg_timeout"]);
    }

    /**
    * Main bot loop
    */
    public function run()
    {
        /**
        * Notify that the bot is running
        */
        echo "Bot is running\r\n";

        while($this->running)
        {
            // Create the url
            $url    = "https://api.telegram.org/bot" . BOT_KEY . "/getUpdates?offset=" . $this->offset . "&limit=1&timeout=60";

            // Initialize curl
            $ch     = curl_init();

            // Set the curl options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Run the query
            $input  = curl_exec($ch);

            // Close the connection
            curl_close($ch);

            // Parse the json returned by the Telegram API
            $input  = json_decode($input, true);

            /**
            * Check if the long polling timeout was reached.
            * If so, don't parse it any further.
            */
            if (!empty($input['result']))
            {
                if (DEBUG)
                var_dump($input);

                // Create an object out of the returned json
                $update = new Update($input["result"][0]);

                if (!in_array($update->getSenderId(), file("config/blacklist")))
                {


                    // If the user is not recognised, add them to the anti flooding array but don't time them out yet
                    if (!isset($this->lastUpdate[$update->getSenderId()]))
                    $this->lastUpdate[$update->getSenderId()] = (time() - MSG_TIMEOUT) - 1;

                    if (time() - $this->lastUpdate[$update->getSenderId()] > MSG_TIMEOUT)
                    {
                        if (new Command($update))
                            // Echo the command to the console for debugging
                            echo "Time: " . time() .  " Command '" . $update->getCommand() . "' with arguments '" . $update->getArguments() . "' issued by '" . $update->getSenderFirstName() . " - " . $update->getSenderId() ."'\r\n";
                        else
                            echo "Time: " . time() . " It looks like a command failed... Command '" . $update->getCommand() . "' with arguments '" . $update->getArguments();
                    } else
                        echo "[THROTTLED] - Time: " . time() . " Command '" . $update->getCommand() . "' with arguments '" . $update->getArguments() . "' issued by '" . $update->getSenderFirstName() . " - " . $update->getSenderId() . "'\r\n";
                }

                // Log the time a user sent a command
                $this->lastUpdate[$update->getSenderId()] = time();

                // Increase the offset for the update_id by one
                $this->offset = $update->getId() + 1;
            }

            // Clear some stuff for the next loop
            $update = '';
            unset($input);
        }
    }

}

// Create a new bot instance
$bot = new Bot();

// Run the bot
$bot->run();

// Should the loop stop for some reason, end it with non-zero status
exit(1);

?>
