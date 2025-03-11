### how to clone
<br>

git clone https://github.com/joshuawenata/asset-manager.git

### how to update
<br>
composer install --ignore-platform-reqs
<br>
php artisan key:generate
<br>
php artisan config:cache
<br>
php artisan migrate:fresh --seed
<br>
composer dump autoload
<br>
php artisan cache:clear
<br>
php artisan view:clear
<br>
php artisan route:clear
<br>
npm run build

### how to run

<br>
1. composer install --ignore-platform-reqs
<br>
2. php artisan serve
<br>
3. copy .env.example .env
<br>
4. add extension=gd in C:\xampp\php\php.ini
<br>
5. add extension=zip in C:\xampp\php\php.ini
<br>
6. composer require laravel/ui
<br>
7. php artisan key:generate
<br>
8. php artisan config:cache
<br>
9. php artisan migrate:fresh --seed
<br>
10. php artisan route:cache 
<br>
11. php artisan ui:auth
<br>
12. composer dump-autoload
<br>
13. npm i vite
<br>
14. npm run build
