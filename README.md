### how to run

<br>
composer install --ignore-platform-reqs
<br>
copy .env.example .env
<br>
php artisan key:generate
<br>
php artisan config:cache
<br>
php artisan migrate:fresh --seed
<br>
php artisan serve
