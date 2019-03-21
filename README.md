# laravel-mailman

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Laravel API for Mailman 3.

## Installation

Via Composer

``` bash
$ composer require himito/laravel-mailman
$ php artisan vendor:publish --tag mailman.config
```

## Configuration

```
MAILMAN_HOST=localhost
MAILMAN_PORT=8001
MAILMAN_USERNAME=
MAILMAN_PASSWORD=
```

## Usage

### Get all the mailing lists

```php
$lists = Mailman::lists();
```

## Change log

Please see the [changelog file](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing file](CONTRIBUTING.md) for details and a todo-list.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Jaime Arias][link-author]
- [All Contributors][link-contributors]

## License

Please see the [license file](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/himito/laravel-mailman.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/himito/laravel-mailman.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/himito/laravel-mailman/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/176921198/shield

[link-packagist]: https://packagist.org/packages/himito/laravel-mailman
[link-downloads]: https://packagist.org/packages/himito/laravel-mailman
[link-travis]: https://travis-ci.org/himito/laravel-mailman
[link-styleci]: https://styleci.io/repos/176921198
[link-author]: https://github.com/himito
[link-contributors]: ../../contributors
