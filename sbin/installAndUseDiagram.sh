#!/usr/bin/env sh
# install
composer require beyondcode/laravel-er-diagram-generator --dev
# ready for use
php artisan vendor:publish --provider=BeyondCode\\ErdGenerator\\ErdGeneratorServiceProvider
# use
php artisan make:model Application
php artisan generate:erd