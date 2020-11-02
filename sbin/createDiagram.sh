#!/usr/bin/env sh
php artisan make:model Application
php artisan make:model ApplicationAnsible
php artisan make:model ApplicationDocker
php artisan make:model ApplicationKubernetes
php artisan make:model ApplicationCloud

# php artisan make:model 

# php artisan make:observer ApplicationAnsible --model=Application
# php artisan make:observer ApplicationDocker --model=Application
# php artisan make:observer ApplicationKubernetes --model=Application
# php artisan make:observer ApplicationCloud --model=Application
# mkdir app/Models/bf
# ln -s ../Observers app/Models/bf/Models
php artisan generate:erd