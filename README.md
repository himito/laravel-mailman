# laravel-mailman

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-actions]][link-actions]
[![StyleCI][ico-styleci]][link-styleci]

A Laravel wrapper around the [Mailman 3 REST API][link-mailman-api]. It lets you
manage mailing lists and their members from your Laravel application.

## Requirements

- PHP 7.4
- Laravel 5.x
- A Mailman 3 Core instance with its REST API reachable from your application

## Installation

Install the package via Composer:

``` bash
composer require himito/laravel-mailman
```

The service provider and the `Mailman` facade are registered automatically
through Laravel's package discovery.

Optionally, publish the configuration file to `config/mailman.php`:

``` bash
php artisan vendor:publish --tag=mailman.config
```

## Configuration

Add the connection details of your Mailman REST API to your `.env` file:

``` dotenv
MAILMAN_HOST=http://localhost
MAILMAN_PORT=8001
MAILMAN_API_VERSION=3.0
MAILMAN_USERNAME=restadmin
MAILMAN_PASSWORD=restpass
```

| Variable              | Default     | Description                                          |
| --------------------- | ----------- | ---------------------------------------------------- |
| `MAILMAN_HOST`        | `http://localhost` | Host of the Mailman REST API. `http://` is assumed if no scheme is given. |
| `MAILMAN_PORT`        | `8001`      | Port of the Mailman REST API.                        |
| `MAILMAN_API_VERSION` | `3.0`       | Version of the REST API to use.                      |
| `MAILMAN_USERNAME`    | (empty)     | REST API admin user (`admin_user` in `mailman.cfg`). |
| `MAILMAN_PASSWORD`    | (empty)     | REST API admin password (`admin_pass` in `mailman.cfg`). |

Requests are sent to `{MAILMAN_HOST}:{MAILMAN_PORT}/{MAILMAN_API_VERSION}/`
using HTTP basic authentication.

## Usage

All methods are available through the `Mailman` facade:

``` php
use Mailman;
```

### Mailing lists

``` php
// Get all the mailing lists
$lists = Mailman::lists();

// Create a new mailing list
Mailman::create_list('news@example.com');

// Update the configuration of a mailing list
Mailman::update_list('news@example.com', [
    'description' => 'Monthly newsletter',
]);

// Remove a mailing list
Mailman::remove_list('news@example.com');
```

### Members

``` php
// Get the members of a mailing list
$members = Mailman::members('news@example.com');

// Subscribe a user to a mailing list (pre-verified, pre-confirmed and pre-approved)
Mailman::subscribe('news@example.com', 'Jane Doe', 'jane@example.com');

// Unsubscribe a user from a mailing list
Mailman::unsubscribe('news@example.com', 'jane@example.com');

// Get all the memberships of a user
$memberships = Mailman::membership('jane@example.com');
```

### Return values

| Method                                     | Returns                                       |
| ------------------------------------------ | --------------------------------------------- |
| `lists()`                                  | `array` of list objects                       |
| `members($list)`                           | `array` of member objects                     |
| `membership($email)`                       | `array` of member objects                     |
| `create_list($list)`                       | `bool`, whether the request succeeded         |
| `update_list($list, $options)`             | `bool`, whether the request succeeded         |
| `remove_list($list)`                       | `bool`, whether the request succeeded         |
| `subscribe($list, $name, $email)`          | `bool`, whether the request succeeded         |
| `unsubscribe($list, $email)`               | `bool`, whether the request succeeded         |

Lists and members are returned as the objects in the `entries` field of the
Mailman API response, so their properties (`list_id`, `fqdn_listname`,
`member_id`, ...) follow the [Mailman REST API documentation][link-mailman-api].
An empty array is returned when the list does not exist or the request fails.

## Change log

Please see the [changelog file](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
composer install
vendor/bin/phpunit tests
```

## Contributing

Please see [contributing file](CONTRIBUTING.md) for details and a todo-list.

## Security

If you discover any security related issues, please email arias@lipn.univ-paris13.fr instead of using the issue tracker.

## Credits

- [Jaime Arias][link-author]
- [All Contributors][link-contributors]

## License

GPL-3.0-or-later. Please see the [license file](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/himito/laravel-mailman.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/himito/laravel-mailman.svg?style=flat-square
[ico-actions]: https://img.shields.io/github/actions/workflow/status/himito/laravel-mailman/php.yml?branch=master&style=flat-square
[ico-styleci]: https://styleci.io/repos/176921198/shield

[link-packagist]: https://packagist.org/packages/himito/laravel-mailman
[link-downloads]: https://packagist.org/packages/himito/laravel-mailman
[link-actions]: https://github.com/himito/laravel-mailman/actions/workflows/php.yml
[link-styleci]: https://styleci.io/repos/176921198
[link-mailman-api]: https://docs.mailman3.org/projects/mailman/en/latest/src/mailman/rest/docs/rest.html
[link-author]: https://github.com/himito
[link-contributors]: ../../contributors
