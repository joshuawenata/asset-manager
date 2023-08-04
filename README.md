### how to run

<br>
composer install --ignore-platform-reqs
<br>
copy .env.example .env
<br>
composer require laravel/ui --ignore-platform-req=ext-gd
<br>
php artisan key:generate
<br>
php artisan config:cache
<br>
php artisan migrate:fresh --seed
<br>
php artisan serve
