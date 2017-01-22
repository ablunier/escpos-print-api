# ESC/POS Print Server API

This application exposes an API to allow print on local thermal receipt printers from the WAN. This project uses and exists thanks to the awesome [mike42/escpos-php](https://github.com/mike42/escpos-php) PHP package.

## The problem

If you want to print from your PHP code to a thermal printer and it is on a different network you will need to stand up a VPN service or something similar. But if you are not able to do this, with this application installed in your local network the problem is solved.

## Installation

This API was developed with the [Lumen PHP framework](https://lumen.laravel.com/). Check its [requirements](https://lumen.laravel.com/docs/5.3#server-requirements) to setup your local server.

1. Clone this repository or download the latest release and place it in your local server.
2. Execute composer install.

## Configuration

1. Setup your [environment configuration](https://lumen.laravel.com/docs/5.3/configuration#environment-configuration).
2. Set your printers.json file. You can use the printers.example.json as an example source.
3. Set the CLIENT_API_TOKEN in your environment configuration.

## Usage

The easiest way print via this API is using [this connector implementation](https://gist.github.com/ablunier/f91e2d2adb8db4c560a9d63f82cb3bb7). With it, you only need to change the connector in your implementation with the [mike42/escpos-php](https://github.com/mike42/escpos-php) PHP package:

```php
<?php 

$connector = new PrintServerApi('https://myapihost', 'printerId', 'MySecretToken');

$printer = new Printer($connector);

$printer->text("Hello World!\n");
$printer->cut();
$printer->close();
```

## License

This application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
