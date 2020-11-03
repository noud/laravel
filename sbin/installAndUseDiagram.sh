#!/usr/bin/env sh
# install
composer require beyondcode/laravel-er-diagram-generator --dev
# ready for use
php artisan vendor:publish --provider=BeyondCode\\ErdGenerator\\ErdGeneratorServiceProvider
# use
php artisan make:model Application
# @todo place Application and User out Models, one up
# @todo correct the so-far
php artisan generate:erd