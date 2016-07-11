# lunabot-telegram
Telegram bot called LunaBot
---
## Install
### Required
- `composer install`
- `cp .env.example .env`

### Docker (optional)
- Change `docker-compose.yml` if needed
- `docker-compose build`
- `docker-compose up -d`
- SSL is not enabled by default

## Configure
Edit `.env` as needed

## Adding commands
Commands should go in `bot/Commands`. When you've created a new command, add it
to the commands array in `bot/Commands/Commands.php` like so:
`'foo' => Foo::class`.

Template command:
```
<?php

namespace Bot\Commands;

class Foo extends Command
{
    protected function handle($bot, $message, $args)
    {
        $bot->sendMessage($message->getChat()->getId(), 'bar!');
    }
}
```
