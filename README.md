# Bot-telegram
> unofficial telegram api wrapper php

![Swag logo](header.png)

## Installation

    ```sh
    composer install
    ```

## Overviews
    ```php
    require __DIR__ . '/vendor/autoload.php';
    use Telegram\Bot\Client;
    $bot = new Client('BOT_TOKEN');
    $bot->sendMessage('hello world','1234'); // message, to
    ```
## Release History

    * 0.0.1
    * Work in progress
## License
    Distributed under the GPL license. See ``LICENSE`` for more information.
## Contributing

    1. Fork it
2. Create your feature branch (`git checkout -b feature/fooBar`)
    3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
    5. Create a new Pull Request

