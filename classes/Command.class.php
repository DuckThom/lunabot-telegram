<?php

/*************************************
 * Class Command
 *
 * All functions, except isValid, should return Send::sendSomething
 *
 * Returned items should look something like this:
 * return Send::sendMessage($chatID, $text, $optional_args)
 *************************************/
class Command {

	private $command;
	private $target;
	private $chatID;
	private $arguments;

	public function __construct(Update $update)
	{
		$this->command 	 = $update->getCommand();
		$this->target 	 = $update->getTarget();
		$this->chatID 	 = $update->getChatId();
		$this->arguments = $update->getArguments();

		if ($this->isValid())
		{
			return $this->run($this->command);
		}
	}

	/**
	 * Check if the command is valid
	 *
	 * @var string
	 * @return boolean
	 */
	public function isValid()
	{
		$commandList    = ["help", "fortune", "boe", "weather", "laugh", "doge", "git", "rigged", "hatquote", "halo"];
		$command 		= preg_replace("/\//", "", $this->command);
		$validTarget    = false;

		// Is this bot the target?
		if ($this->target === "LunaBot" || $this->target === false)
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
		return $this->$command();
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
				"/laugh  -  Make me laugh \r\n" .
				"/rigged  -  Make sure I'm not rigged \r\n";

		return Send::sendMessage($this->chatID, $text);
	}

	/**
	 * Give a person a (fortune) cookie
	 *
	 * @return boolean
	 */
	public function fortune()
	{
		$text = '';

		exec("fortune -a", $out, $code);

		// If the return code is 0 (successful) return the fortune
		if ($code === 0) {
			foreach($out as $line) // Needed for multi-line fortunes
				$text .= $line . "\r\n";

			$text = preg_replace("/Mark\sTwain/", 'Mark "The Twat" Twain', $text);
		} else
			$text = "No fortunes found :(";

		return Send::sendMessage($this->chatID, $text);
	}

	/**
	 * I'm scjert
	 *
	 * @return boolean
	 */
	public function boe()
	{
		return Send::sendMessage($this->chatID, "Schrik!");
	}

	/**
	 * Display the weather for the queried location
	 *
	 * @var string
	 * @return array
	 */
	public function weather()
	{
		$location = $this->arguments;

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

		return Send::sendMessage($this->chatID, $text);
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
				"rofl",
				"roflcopter",
				"55555",
				"www",
			];

		$text = $laughList[array_rand($laughList)];

		return Send::sendMessage($this->chatID, $text);
	}

	/**
	 * Send a doge sticker
	 *
	 * @return array
	 */
	public function doge()
	{
		return Send::sendSticker($this->chatID, Emoji::getSticker('doge'));
	}

	/**
	 * Search for something on GitHub
	 *
	 * @var string
	 * @return array
	 */
	public function git()
	{
		$query = $this->arguments;

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

		return Send::sendMessage($this->chatID, $text, true);
	}

	/**
	 * Make sure that the bot is not rigged
	 *
	 * @return array
	 */
	public function rigged()
	{
		$riggedList = [
			"I'm not rigged ye bastard!",
			"Fock off m8, I'm not rigged!",
			"No rigging here!",
			"Really, 'topkek' is only random! REALLY!!!!111oneone"
		];

		$text = $riggedList[array_rand($riggedList)];

		return Send::sendMessage($this->chatID, $text);
	}

	/**
	 * Show a random Hat Films quote
	 *
	 * @return array
	 */
	public function hatquote()
	{
		$quoteList = [
			"Eat Shit! - Djh3max",
			"Are you hungry? Eat Shit! - Djh3max",
			"Are you feeling peckish? Eat Shit! - Djh3max",
			"Eat the Shit! - Djh3max",
			"Eat a fistful of Shit! - Djh3max",
			"Someone's about to eat a lot of shit. - Djh3max",
			"Stay frosty! - Djh3max",
			"IT'S NOT ME! - Djh3max",
			"Put a bit of lava in the drum. - Djh3max",
			"#Horny4Hornby. - Djh3max",
			"Go suck a big fat one, you massive pleb. - Djh3max",
			"Got any marble? - Djh3max",
			"Cobble is a gateway drug. - Djh3max",
			"JOOONNNNN SNNOOOWWWW! - Djh3max",
			"HE WANTS YOU TO BATTER HIS BUTTHOLE! - Djh3max",
			"GFY! - Djh3max",
			"I was just bouncing around like a TIT IN THE BREEZE! - Djh3max",
			"Yeah, we're ahead of you bitch! HAHAHA!!!! - Djh3max",

			"DEEAALSS. - Trottimus",
			"I'm aroused. - Trottimus",
			"Filthy dirt! - Trottimus",
			"I'm milking in the air! - Trottimus",
			"Praise the hand of truth! - Trottimus",
			"SORRY SUNSHINE. - Trottimus",
			"So horny right now... - Trottimus",
			"ROOOSSSSSSSS - Trottimus",
			"I'm in the bath tub Rosss - Trottimus",
			"Alex Smithicles - Trottimus",
			"What does LSD stand for? 'Lympic Sport Dancers' - Trottimus",
			"AW Take this in the face you, dirty pleb! - Trottimus",

			"Do me! - Alsmiffy",
			"Go on, do him! - Alsmiffy",
			"FUCK YOU TROTT! - Alsmiffy",
			"Take your trousers off! - Alsmiffy",
			"SHIT! - Alsmiffy",
			"SHIT, SHIT, SHIT! - Alsmiffy",
			"SO RANDY! - Alsmiffy",
			"WE GOT A TWO FOR ONE SPECIAL ON COCK AND BALLS! - Alsmiffy",
			"STICK A COCK IN YOUR WHOLE FAMILY. - Alsmiffy",
			"Oh long Johnson! - Alsmiffy",
			"Interestingly \"hunt\" rhymes with something that Ross is. - Alsmiffy",
			"Shut up Trott, you prick! - Alsmiffy",
			"This is the big one. This is the one we've been working up to guys! - Alsmiffy",
			"Classic Chris Trott error. - Alsmiffy",
			"What's the angle, what's the pitch, what's the PLAAAAY?! - Alsmiffy",
			"He's got a real appetite for candy... AND banging - Alsmiffy",
			"I'm gonna cut your fucking dick off mate - Alsmiffy",
			"People in the comments keep telling me to open my eyes but they are open - Alsmiffy",
			"I'm back here birthing babies like crazy - Alsmiffy",
			"Get in the mixer! - Alsmiffy",
			"That was fucking quality! - Alsmiffy",
			"I was gonna say I'd fuck Trott, then kill myself. - Alsmiffy",
			"I was concentrating too hard on fucking him, when I should have just been focusing on eating the dicks! - Alsmiffy",
		];

		$text = $quoteList[array_rand($quoteList)];

		return Send::sendMessage($this->chatID, $text);
	}

	/**
	 * Show the spartan for the matched gamertag
	 *
	 * @return mixed
	 */
	public function halo()
	{
		$arg = $this->arguments;
		// Remove any non alphabetical/numerical chars
		preg_match_all("/[a-zA-Z0-9]*/", $arg, $gamertag);

		$gamertag = $gamertag[0][0];

		if ($gamertag == '')
		{
			return $text = "Usage: /halo <gamertag>";
		} else {
			$url 	= "https://www.haloapi.com/profile/h5/profiles/" . $gamertag . "/spartan";

			// Initialize curl
			$ch 	= curl_init();
			// Set the curl options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, [
		        "Ocp-Apim-Subscription-Key: " . HALO_KEY,
		    ]);

			$image 	= curl_exec($ch);
			$code 	= curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);

			if ($code === 200)
			{
				$tmpfname = tempnam(sys_get_temp_dir(), "lunabot") . ".png";

				$handle = fopen($tmpfname, "w");
				fwrite($handle, $image);
				fclose($handle);

				return Send::sendPhoto($this->chatID, $tmpfname, $gamertag);
			} else {
				$text = "No spartan was found with the gamertag: " . $gamertag;
			}
		}

		return Send::sendMessage($this->chatID, $text);
	}
}
