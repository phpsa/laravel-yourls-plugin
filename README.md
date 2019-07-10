# Laravel Yourls Plugin
[![For Laravel 5][badge_laravel]](https://github.com/phpsa/laravel-api-controller/issue)
[![Build Status](https://travis-ci.org/phpsa/laravel-yourls-plugin.svg?branch=master)](https://travis-ci.org/phpsa/laravel-yourls-plugin)
[![styleci](https://styleci.io/repos/196083755/shield)](https://styleci.io/repos/196083755)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpsa/laravel-yourls-plugin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpsa/laravel-yourls-plugin/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/phpsa/laravel-yourls-plugin/badge.svg?branch=master)](https://coveralls.io/github/phpsa/laravel-yourls-plugin?branch=master)

[![Packagist](https://img.shields.io/packagist/v/phpsa/laravel-yourls-plugin.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)
[![Packagist](https://poser.pugx.org/phpsa/laravel-yourls-plugin/d/total.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)
[![Packagist](https://img.shields.io/packagist/l/phpsa/laravel-yourls-plugin.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)
[![Github Issues][badge_issues]](https://github.com/phpsa/laravel-api-controller/issue)

Package description: Plugin which integrates Laravel with Yourls (Your Own URL Shortener).

## Installation

Install via composer
```bash
composer require phpsa/laravel-yourls-plugin
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Phpsa\LaravelYourlsPlugin\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
'ShortUrl' => Phpsa\LaravelYourlsPlugin\Facades\LaravelYourlsPlugin::class,
```

### Publish Configuration File (optional)

```bash
php artisan vendor:publish --provider="Phpsa\LaravelYourlsPlugin\ServiceProvider" --tag="config"
```

### Configuration Settings

you can set the following values in your environment file

```bash
LARAVEL_YOURLS_PLUGIN_URL=
LARAVEL_YOURLS_PLUGIN_USERNAME=
LARAVEL_YOURLS_PLUGIN_PASSWORD=
LARAVEL_YOURLS_PLUGIN_SIGNATURE=
LARAVEL_YOURLS_PLUGIN_FORMAT=json
```

Authentication can use either the username / password combo or the signature

## Usage

using the Facade: you can access the following methods:

### shorturl
*Generates a short url for your long url*

```php
\ShortUrl::shorturl(string $url [, string $title = NULL [], string $keyword = NULL [], string $format = NULL ]]] )
```

**Parameters**
+ *$url* - required - the url you wish to create a short url for
+ *$title* - optional - Title of the short url
+ *$keyword* - optional - Title for the short url (ie short.url/{keyword})
+ *$format* - optional - Change the format for this specific request (json / xml)

**Returns**
string - the short url that was generated


### expand
*Expands inforation about your short url*
```php
\ShortUrl::expand(string $shorturl [, string $format = null] )
```

**Parameters**
+ *$shorturl* - required - the shorturl to expand (can be either 'abc' or 'http://site/abc')
+ *$format* - optional - Change the format for this specific request (json / xml)

**Returns**
stdClass - object of the response details

### urlStats
*Get stats about one short URL*
```php
\ShortUrl::expand(string $shorturl [, string $format = null] )
```

**Parameters**
+ *$shorturl* - required - the shorturl to expand (can be either 'abc' or 'http://site/abc')
+ *$format* - optional - Change the format for this specific request (json / xml)

**Returns**
stdClass - object of the response details

### stats
*Get stats about one short URL*
```php
\ShortUrl::stats( [string $filter = null [, int $limit = null [, string $format = null ]]] )
```

**Parameters**
+ *$filter* - optional - the filter: either "top", "bottom" , "rand" or "last"
+ *$limit* - optional - the limit (maximum number of links to return)
+ *$format* - optional - Change the format for this specific request (json / xml)

**Returns**
stdClass - object of the response details

### dbStats
*Get stats about one short URL*
```php
\ShortUrl::dbStats([ string $format = null] )
```

**Parameters**
+ *$format* - optional - Change the format for this specific request (json / xml)

**Returns**
stdClass - object of the response details

### getLastResponse
*Gets the full response body from the last request*
```php
\ShortUrl::getLastResponse()
```
**Parameters**
N/A

**Returns**
stdClass|string response of the last request body

## Security

If you discover any security related issues, please email
instead of using the issue tracker.

## Credits

- [Craig Smith](https://github.com/phpsa)
- [All contributors](https://github.com/phpsa/laravel-yourls-plugin/graphs/contributors)


[badge_laravel]:   https://img.shields.io/badge/Laravel-5.8%20to%205.8-orange.svg?style=flat-square
[badge_issues]:    https://img.shields.io/github/issues/ARCANEDEV/Support.svg?style=flat-square