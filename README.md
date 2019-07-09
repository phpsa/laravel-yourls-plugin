# Laravel Yourls Plugin

[![Build Status](https://travis-ci.org/phpsa/laravel-yourls-plugin.svg?branch=master)](https://travis-ci.org/phpsa/laravel-yourls-plugin)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpsa/laravel-yourls-plugin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpsa/laravel-yourls-plugin/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/phpsa/laravel-yourls-plugin/badge.svg?branch=master)](https://coveralls.io/github/phpsa/laravel-yourls-plugin?branch=master)

[![Packagist](https://img.shields.io/packagist/v/phpsa/laravel-yourls-plugin.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)
[![Packagist](https://poser.pugx.org/phpsa/laravel-yourls-plugin/d/total.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)
[![Packagist](https://img.shields.io/packagist/l/phpsa/laravel-yourls-plugin.svg)](https://packagist.org/packages/phpsa/laravel-yourls-plugin)

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

## Usage

using the Facade: you can access the following methods:

**shorturl** - Generates a short url for your long url
```php
\ShortUrl::shorturl(string $url [, string $title = NULL [], string $keyword = NULL [], string $format = NULL ]]] )
```
+ *$url* - required - the url you wish to create a short url for
+ *$title* - optional - Title of the short url
+ *$keyword* - optional - Title for the short url (ie short.url/{keyword})
+ *$format* - optional - Change the format for this specific request


```php
\ShortUrl::shorturl($url)
\ShortUrl::expand($shortUrl)
\ShortUrl::urlStats($shortUrl)
\ShortUrl::stats
\ShortUrl::dbStats
\ShortUrl::getLastResponse


## Security

If you discover any security related issues, please email
instead of using the issue tracker.

## Credits

- [Craig Smith](https://github.com/phpsa)
- [All contributors](https://github.com/phpsa/laravel-yourls-plugin/graphs/contributors)
