# Laravel Akeneo images

<p>
    <a href="https://github.com/justbetter/laravel-akeneo-images"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-images/tests.yml?label=tests&style=flat-square" alt="Tests"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-images"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-images/coverage.yml?label=coverage&style=flat-square" alt="Coverage"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-images"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-images/analyse.yml?label=analysis&style=flat-square" alt="Analysis"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-images"><img src="https://img.shields.io/packagist/dt/justbetter/laravel-akeneo-images?color=blue&style=flat-square" alt="Total downloads"></a>
</p>

This package is used to download images from a storage disk configured in the `config/filesystems.php` of your Laravel
project and upload them to your Akeneo PIM.

## How it works

The process of setting images in Akeneo consists of two steps.

In order to set images, the disk and path are saved with a checksum of the file in the database. This way we prevent
uploading the same image over and over again.

Next, the image will be uploaded. By using the information stored in the database, the data is sent over to Akeneo.

## Installation

You can install the package via composer.

```shell
composer require justbetter/laravel-akeneo-images
```

## Setup

If you wish to configure the `queue` of jobs, publish the configuration of this package.

```shell
php artisan vendor:publish --provider="JustBetter\AkeneoImages\ServiceProvider" --tag=config
```

## Configuration

Make sure you have a disk configured in your `config/filesystems.php`.

Set up your Akeneo connection. More information can be found [here](https://github.com/justbetter/laravel-akeneo-client#configuration).

## Implementation

In order to start processing images, the `ProcessImageJob` has to be dispatched. This is the only thing you'll have to
do when using the default functionalities.

```php
<?php

use JustBetter\AkeneoImages\Jobs\ProcessImageJob;

ProcessImageJob::dispatch('disk', '/path/to/image.jpeg', [
    'identifier' => 'sku',
    'attribute' => 'image',
    'type' => 'product',
    'scope' => null,
    'locale' => null,
]);
```

The third parameter is an array which represents the `$meta`. This is used in the `UploadImageJob` in order to determine
where the image has to be uploaded to.

The `UploadImageJob` is automatically dispatched by the `ProcessImage` action when the image passes validation, so there
is no need to dispatch this manually.

## Commands

This package also ships with a few commands.

```shell
php artisan akeneo-image:process {disk} {path} {--force}
php artisan akeneo-image:upload {image-id}
```

## Quality

To ensure the quality of this package, run the following command:

```shell
composer quality
```

This will execute three tasks:

1. Makes sure all tests are passed
2. Checks for any issues using static code analysis
3. Checks if the code is correctly formatted

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ramon Rietdijk](https://github.com/ramonrietdijk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
