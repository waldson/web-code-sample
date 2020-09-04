# Sample To-Do

This document explains how to setup and run this sample to-do.

## Requirements

* `PHP` 7.1+ with `sqlite` extension enabled
* `composer` 1.7+
* `yarn` 1.9+ or `npm` 6.1+

## Installation

* Run `composer install`

## Execution

* Run `php -S localhost:8080 -t public public/index.php`
* Open your browser on `localhost:8080`

## Tests

* Run `./vendor/bin/phpunit`

## Modify Assets

* Run `cd resources/assets && yarn install`
* Run `yarn watch`
* Edit source files
* To compile production version of assets, run `yarn run prod`

