<?php

namespace Bot\Commands;

use Bot\Client;
use TelegramBot\Api\Types\Message;

/**
 * Class Hatquote
 * @package Bot\Commands
 */
class Hatquote extends Command
{
    /**
     * List of possible responses.
     *
     * @var array
     */
    private $responses = [
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

    /**
     * Command handler.
     *
     * @param  Client $bot
     * @param  \TelegramBot\Api\Types\Message $message
     * @param  array $args
     */
    protected function handle(Client $bot, Message $message, $args)
    {
        $text = $this->responses[array_rand($this->responses)];

        $bot->sendMessage($message->getChat()->getId(), $text);
    }
}
