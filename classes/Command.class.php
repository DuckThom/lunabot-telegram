<?php

/*************************************
 * Class Command
 *
 * All functions, except isValid, should return Send::sendSomething
 *
 * Returned items should look something like this:
 * return Send::sendMessage($chatID, $text, $optional_args)
 *************************************/
class Command extends Bot {

	/**
	 * Check if the command is valid
	 *
	 * @var string
	 * @return boolean
	 */
	public function isValid($command, $target)
	{
		$commandList = ["help", "fortune", "boe", "weather", "laugh", "doge", "git"];
		$command 	 = preg_replace("/\//", "", $command);
		$validTarget = false;

		// Is this bot the target?
		if ($target === "LunaBot" || $target === false)
			$validTarget = true;
		
		// Is the command in the known command list and is this bot the target?
		if (in_array($command, $commandList) && $validTarget === true)
			return true;
		else
			return false;
	}

	/**
	 * Called when a command is going to run
	 *
	 * @return boolean
	 */
	public function run($command)
	{
		return Command::$command();
	}

	/**
	 * Dispense some help to a damsel in distress
	 *
	 * @return boolean
	 */
	public function help()
	{
		$text = "Possible commands: \r\n" .
				"/help  -  Display this message \r\n" .
				"/weather <location>  -  Get the weather for that location\r\n" .
				"/boe  -  Scare me \r\n" . 
				"/fortune  -  Get a fortune cookie \r\n" .
				"/doge  -  Send a doge sticker \r\n" . 
				"/git <query>  -  Search for a repository on GitHub \r\n" .
				"/laugh  -  Make me laugh \r\n";
		
		return Send::sendMessage($this->update->message->chat->getId(), $text);
	}

	/**
	 * Give a person a (fortune) cookie
	 *
	 * @return boolean
	 */
	public function fortune()
	{
		$text = '';

		exec("fortune", $out, $code);

		// If the return code is 0 (successful) return the fortune
		if ($code === 0)	
			foreach($out as $line) // Needed for multi-line fortunes
				$text .= $line . "\r\n";
		else
			$text = "No fortunes found :(";

		return Send::sendMessage($this->update->message->chat->getId(), $text);
	}

	/**
	 * I'm scjert
	 *
	 * @return boolean
	 */
	public function boe()
	{
		return Send::sendMessage($this->update->message->chat->getId(), "Schrik!");
	}

	/**
	 * Display the weather for the queried location
	 *
	 * @var string
	 * @return array
	 */
	public function weather()
	{
		$location = $this->update->message->getArgument();

		if ($location === '')
			$text = "Usage: /weather <location>";
		else
		{
			$location = preg_replace("/\s/", "%20", $location);

			// Create the url
			$url 	= "http://api.openweathermap.org/data/2.5/weather?q=" . $location . "&APPID=" . OWM_KEY;
			
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

			if (DEBUG)
				var_dump($input);

			// Has the location been found by the OpenWeatherMap API
			if (isset($input["cod"]))
				if ($input["cod"] !== 200)
					$text = "No weather data found for this location: " . ucfirst($location);
				else
					$text = "City: " . ucfirst($location) . "\r\n" .
						    "Temperature: " . round($input["main"]["temp"] - 272.15, 1) . " °C \r\n" .
						    "Weather: " . $input["weather"][0]["main"] . " " . Emoji::getOWMEmoji(rtrim($input["weather"][0]["icon"], "nd"));
			else
				$text = "Error retrieving weather data, please try again later";
		}

		return Send::sendMessage($this->update->message->chat->getId(), $text);
	}

	/**
	 * Return a random laugh
	 *
	 * @return array
	 */
	public function laugh()
	{
		$laughList = [
				"HAHAHAHAHAHAHAHAHAHAHAHAHAHA",
				"mwaahaAHAHAAHHAHAAHHAHAHA",
				"hehe",
				"hahahahaha",
				"hahahaAHAHAHA",
				"TeeHee",
				"kek",
				"topkek",
				"lol",
				"lawl",
				"haha",
				"huehuehue",
				"lololololol",
				"trolololol",
				"hihihihihi",
				"lmao",
				"rofl"
			];

		$text = $laughList[array_rand($laughList)];

		return Send::sendMessage($this->update->message->chat->getId(), $text);
	}

	/**
	 * Send a doge sticker
	 *
	 * @return array
	 */
	public function doge()
	{
		return Send::sendSticker($this->update->message->chat->getId(), Emoji::getSticker('doge'));
	}

	/**
	 * Search for something on GitHub
	 *
	 * @var string
	 * @return array
	 */
	public function git()
	{
		$query = $this->update->message->getArgument();

		if ($query === '')
			$text = "Usage: /git <query>";
		else
		{
			$query  = preg_replace("/\s/", "%20", $query);

			// Create the url
			$url 	= "https://api.github.com/search/repositories?q=" . $query;
			
			// Initialize curl
			$ch 	= curl_init();

			// Set the curl options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

			// Run the query
			$input 	= curl_exec($ch);

			// Close the connection
			curl_close($ch);

			// Parse the json returned by the GitHub Search API
			$input 	= json_decode($input, true);

			if (DEBUG)
				var_dump($input);

			if (isset($input["total_count"]))
				// Are there any results?
				if ($input["total_count"] === 0)
					$text = "No git repositories found with: " . ucfirst($query);
				else
					// Always return the first result from the array
					$text = "Showing top result: \r\n" .
							"User: " . $input["items"][0]["owner"]["login"] . "\r\n" .
							"Repo: " . $input["items"][0]["name"] . "\r\n" . 
							$input["items"][0]["html_url"];
			else
				$text = "Error retrieving git data, please try again later";
		}

		return Send::sendMessage($this->update->message->chat->getId(), $text, true);
	}
}

?>