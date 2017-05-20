# Twitch-PHP

[![Latest Stable Version](https://poser.pugx.org/richard4339/twitch-php/v/stable)](https://packagist.org/packages/richard4339/twitch-php)
[![Total Downloads](https://poser.pugx.org/richard4339/twitch-php/downloads)](https://packagist.org/packages/richard4339/twitch-php)
[![Latest Unstable Version](https://poser.pugx.org/richard4339/twitch-php/v/unstable)](https://packagist.org/packages/richard4339/twitch-php)
[![License](https://poser.pugx.org/richard4339/twitch-php/license)](https://packagist.org/packages/richard4339/twitch-php)
[![composer.lock](https://poser.pugx.org/richard4339/twitch-php/composerlock)](https://packagist.org/packages/richard4339/twitch-php)
[![Build Status](https://travis-ci.org/richard4339/Twitch-PHP.svg?branch=master)](https://travis-ci.org/richard4339/Twitch-PHP)

PHP wrapper for the Twitch API

## Installation
### Using Composer
```
composer require richard4339/twitch-php
```

## Notes
Defaults to version 5 of the Twitch API which has breaking changes from version 3 when retrieving streams. As a result, there are breaking changes when upgrading to version 1 of this package.

## Requirements
Uses the GuzzleHTTP package