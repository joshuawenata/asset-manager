### how to run

composer install --ignore-platform-reqs
<br>
php artisan serve


Microsoft Windows [Version 10.0.17763.3887]
(c) 2018 Microsoft Corporation. All rights reserved.

D:\xampp\htdocs\asset-manager>php -v
PHP 8.2.3 (cli) (built: Feb 14 2023 09:55:52) (ZTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.2.3, Copyright (c) Zend Technologies

D:\xampp\htdocs\asset-manager>composer install
Installing dependencies from lock file (including require-dev)
Verifying lock file contents can be installed on current platform.
Package operations: 118 installs, 0 updates, 0 removals
  - Installing voku/portable-ascii (2.0.1): Extracting archive
  - Installing symfony/polyfill-php80 (v1.27.0): Extracting archive
  - Installing symfony/polyfill-mbstring (v1.27.0): Extracting archive
  - Installing symfony/polyfill-ctype (v1.27.0): Extracting archive
  - Installing phpoption/phpoption (1.9.0): Extracting archive
  - Installing graham-campbell/result-type (v1.1.0): Extracting archive
  - Installing vlucas/phpdotenv (v5.5.0): Extracting archive
  - Installing symfony/css-selector (v6.0.17): Extracting archive
  - Installing tijsverkoyen/css-to-inline-styles (2.2.5): Extracting archive
  - Installing symfony/var-dumper (v6.0.17): Extracting archive
  - Installing symfony/polyfill-uuid (v1.27.0): Extracting archive
  - Installing symfony/uid (v6.0.13): Extracting archive
  - Installing symfony/routing (v6.0.17): Extracting archive
  - Installing symfony/process (v6.0.11): Extracting archive
  - Installing symfony/polyfill-php72 (v1.27.0): Extracting archive
  - Installing symfony/polyfill-intl-normalizer (v1.27.0): Extracting archive
  - Installing symfony/polyfill-intl-idn (v1.27.0): Extracting archive
  - Installing symfony/mime (v6.0.17): Extracting archive
  - Installing psr/container (2.0.2): Extracting archive
  - Installing symfony/service-contracts (v3.0.2): Extracting archive
  - Installing psr/event-dispatcher (1.0.0): Extracting archive
  - Installing symfony/event-dispatcher-contracts (v3.0.2): Extracting archive
  - Installing symfony/event-dispatcher (v6.0.17): Extracting archive
  - Installing psr/log (3.0.0): Extracting archive
  - Installing doctrine/deprecations (v1.0.0): Extracting archive
  - Installing doctrine/lexer (2.1.0): Extracting archive
  - Installing egulias/email-validator (3.2.5): Extracting archive
  - Installing symfony/mailer (v6.0.17): Extracting archive
  - Installing symfony/deprecation-contracts (v3.0.2): Extracting archive
  - Installing symfony/http-foundation (v6.0.17): Extracting archive
  - Installing symfony/error-handler (v6.0.17): Extracting archive
  - Installing symfony/http-kernel (v6.0.18): Extracting archive
  - Installing symfony/finder (v6.0.17): Extracting archive
  - Installing symfony/polyfill-intl-grapheme (v1.27.0): Extracting archive
  - Installing symfony/string (v6.0.17): Extracting archive
  - Installing symfony/console (v6.0.17): Extracting archive
  - Installing symfony/polyfill-php81 (v1.27.0): Extracting archive
  - Installing ramsey/collection (1.3.0): Extracting archive
  - Installing brick/math (0.10.2): Extracting archive
  - Installing ramsey/uuid (4.7.1): Extracting archive
  - Installing psr/simple-cache (3.0.0): Extracting archive
  - Installing nunomaduro/termwind (v1.15.0): Extracting archive
  - Installing symfony/translation-contracts (v3.0.2): Extracting archive
  - Installing symfony/translation (v6.0.14): Extracting archive
  - Installing nesbot/carbon (2.64.1): Extracting archive
  - Installing monolog/monolog (2.8.0): Extracting archive
  - Installing league/mime-type-detection (1.11.0): Extracting archive
  - Installing league/flysystem (3.12.0): Extracting archive
  - Installing nette/utils (v3.2.8): Extracting archive
  - Installing nette/schema (v1.2.3): Extracting archive
  - Installing dflydev/dot-access-data (v3.0.2): Extracting archive
  - Installing league/config (v1.2.0): Extracting archive
  - Installing league/commonmark (2.3.8): Extracting archive
  - Installing laravel/serializable-closure (v1.2.2): Extracting archive
  - Installing fruitcake/php-cors (v1.2.0): Extracting archive
  - Installing webmozart/assert (1.11.0): Extracting archive
  - Installing dragonmantank/cron-expression (v3.3.2): Extracting archive
  - Installing doctrine/inflector (2.0.6): Extracting archive
  - Installing laravel/framework (v9.45.1): Extracting archive
  - Installing codedge/laravel-fpdf (1.10.0): Extracting archive
  - Installing fakerphp/faker (v1.21.0): Extracting archive
  - Installing psr/http-message (1.0.1): Extracting archive
  - Installing psr/http-client (1.0.1): Extracting archive
  - Installing ralouphie/getallheaders (3.0.3): Extracting archive
  - Installing psr/http-factory (1.0.1): Extracting archive
  - Installing guzzlehttp/psr7 (2.4.3): Extracting archive
  - Installing guzzlehttp/promises (1.5.2): Extracting archive
  - Installing guzzlehttp/guzzle (7.5.0): Extracting archive
  - Installing laravel/pint (v1.3.0): Extracting archive
  - Installing laravel/sail (v1.16.6): Extracting archive
  - Installing laravel/sanctum (v3.0.1): Extracting archive
  - Installing nikic/php-parser (v4.15.2): Extracting archive
  - Installing psy/psysh (v0.11.10): Extracting archive
  - Installing laravel/tinker (v2.7.3): Extracting archive
  - Installing laravel/ui (v4.1.1): Extracting archive
  - Installing markbaker/matrix (3.0.1): Extracting archive
  - Installing markbaker/complex (3.0.2): Extracting archive
  - Installing myclabs/php-enum (1.8.4): Extracting archive
  - Installing maennchen/zipstream-php (v2.4.0): Extracting archive
  - Installing ezyang/htmlpurifier (v4.16.0): Extracting archive
  - Installing phpoffice/phpspreadsheet (1.26.0): Extracting archive
  - Installing composer/semver (3.3.2): Extracting archive
  - Installing maatwebsite/excel (3.1.45): Extracting archive
  - Installing hamcrest/hamcrest-php (v2.0.1): Extracting archive
  - Installing mockery/mockery (1.5.1): Extracting archive
  - Installing filp/whoops (2.14.6): Extracting archive
  - Installing nunomaduro/collision (v6.3.2): Extracting archive
  - Installing sebastian/version (3.0.2): Extracting archive
  - Installing sebastian/type (3.2.0): Extracting archive
  - Installing sebastian/resource-operations (3.0.3): Extracting archive
  - Installing sebastian/recursion-context (4.0.4): Extracting archive
  - Installing sebastian/object-reflector (2.0.4): Extracting archive
  - Installing sebastian/object-enumerator (4.0.4): Extracting archive
  - Installing sebastian/global-state (5.0.5): Extracting archive
  - Installing sebastian/exporter (4.0.5): Extracting archive
  - Installing sebastian/environment (5.1.4): Extracting archive
  - Installing sebastian/diff (4.0.4): Extracting archive
  - Installing sebastian/comparator (4.0.8): Extracting archive
  - Installing sebastian/code-unit (1.0.8): Extracting archive
  - Installing sebastian/cli-parser (1.0.1): Extracting archive
  - Installing phpunit/php-timer (5.0.3): Extracting archive
  - Installing phpunit/php-text-template (2.0.4): Extracting archive
  - Installing phpunit/php-invoker (3.1.1): Extracting archive
  - Installing phpunit/php-file-iterator (3.0.6): Extracting archive
  - Installing theseer/tokenizer (1.2.1): Extracting archive
  - Installing sebastian/lines-of-code (1.0.3): Extracting archive
  - Installing sebastian/complexity (2.0.2): Extracting archive
  - Installing sebastian/code-unit-reverse-lookup (2.0.3): Extracting archive
  - Installing phpunit/php-code-coverage (9.2.23): Extracting archive
  - Installing phar-io/version (3.2.1): Extracting archive
  - Installing phar-io/manifest (2.0.3): Extracting archive
  - Installing myclabs/deep-copy (1.11.0): Extracting archive
  - Installing doctrine/instantiator (1.5.0): Extracting archive
  - Installing phpunit/phpunit (9.5.27): Extracting archive
  - Installing spatie/backtrace (1.2.1): Extracting archive
  - Installing spatie/flare-client-php (1.3.2): Extracting archive
  - Installing spatie/ignition (1.4.1): Extracting archive
  - Installing spatie/laravel-ignition (1.6.3): Extracting archive
Generating optimized autoload files
Class App\Models\assetLocation located in D:/xampp/htdocs/asset-manager/app\Models\AssetLocation.php does not comply with psr-4 autoloading standard. Skipping.
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.

  codedge/laravel-fpdf .......................................................................................... DONE
  laravel/sail .................................................................................................. DONE
  laravel/sanctum ............................................................................................... DONE
  laravel/tinker ................................................................................................ DONE
  laravel/ui .................................................................................................... DONE
  maatwebsite/excel ............................................................................................. DONE
  nesbot/carbon ................................................................................................. DONE
  nunomaduro/collision .......................................................................................... DONE
  nunomaduro/termwind ........................................................................................... DONE
  spatie/laravel-ignition ....................................................................................... DONE

86 packages you are using are looking for funding.
Use the `composer fund` command to find out more!

D:\xampp\htdocs\asset-manager>php artisan --version
Laravel Framework 9.45.1

D:\xampp\htdocs\asset-manager>copy .env.example .env
        1 file(s) copied.

D:\xampp\htdocs\asset-manager>composer require laravel/ui
Info from https://repo.packagist.org: #StandWithUkraine
./composer.json has been updated
Running composer update laravel/ui
Loading composer repositories with package information
Updating dependencies
Lock file operations: 0 installs, 1 update, 0 removals
  - Upgrading laravel/ui (v4.1.1 => v4.2.1)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 0 installs, 1 update, 0 removals
  - Upgrading laravel/ui (v4.1.1 => v4.2.1): Extracting archive
Generating optimized autoload files
Class App\Models\assetLocation located in D:/xampp/htdocs/asset-manager/app\Models\AssetLocation.php does not comply with psr-4 autoloading standard. Skipping.
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.

  codedge/laravel-fpdf .......................................................................................... DONE
  laravel/sail .................................................................................................. DONE
  laravel/sanctum ............................................................................................... DONE
  laravel/tinker ................................................................................................ DONE
  laravel/ui .................................................................................................... DONE
  maatwebsite/excel ............................................................................................. DONE
  nesbot/carbon ................................................................................................. DONE
  nunomaduro/collision .......................................................................................... DONE
  nunomaduro/termwind ........................................................................................... DONE
  spatie/laravel-ignition ....................................................................................... DONE

86 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
> @php artisan vendor:publish --tag=laravel-assets --ansi --force

   INFO  No publishable resources for tag [laravel-assets].

Found 1 security vulnerability advisory affecting 1 package.
Run composer audit for a full list of advisories.
Using version ^4.2 for laravel/ui

D:\xampp\htdocs\asset-manager>php artisan ui:auth

  The [auth/login.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [auth/passwords/confirm.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [auth/passwords/email.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [auth/passwords/reset.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [auth/register.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [auth/verify.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [home.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [layouts/app.blade.php] view already exists. Do you want to replace it? (yes/no) [no]
❯ no

  The [HomeController.php] file already exists. Do you want to replace it? (yes/no) [no]
❯ no

   INFO  Authentication scaffolding generated successfully.


D:\xampp\htdocs\asset-manager>php artisan key:generate

   INFO  Application key set successfully.


D:\xampp\htdocs\asset-manager>php artisan config:cache

   INFO  Configuration cached successfully.


D:\xampp\htdocs\asset-manager>php artisan route:cache

   LogicException

  Unable to prepare route [login] for serialization. Another route has already been assigned name [login].

  at D:\xampp\htdocs\asset-manager\vendor\laravel\framework\src\Illuminate\Routing\AbstractRouteCollection.php:247
    243▕             $route->name($this->generateRouteName());
    244▕
    245▕             $this->add($route);
    246▕         } elseif (! is_null($symfonyRoutes->get($name))) {
  ➜ 247▕             throw new LogicException("Unable to prepare route [{$route->uri}] for serialization. Another route has already been assigned name [{$name}].");
    248▕         }
    249▕
    250▕         $symfonyRoutes->add($route->getName(), $route->toSymfonyRoute());
    251▕

  1   D:\xampp\htdocs\asset-manager\vendor\laravel\framework\src\Illuminate\Routing\AbstractRouteCollection.php:208
      Illuminate\Routing\AbstractRouteCollection::addToSymfonyRoutesCollection(Object(Symfony\Component\Routing\RouteCollection), Object(Illuminate\Routing\Route))

  2   D:\xampp\htdocs\asset-manager\vendor\laravel\framework\src\Illuminate\Routing\RouteCollection.php:246
      Illuminate\Routing\AbstractRouteCollection::toSymfonyRouteCollection()

D:\xampp\htdocs\asset-manager>php artisan view:cache

   INFO  Blade templates cached successfully.


D:\xampp\htdocs\asset-manager>php artisan migrate:fresh --seed

  Dropping all tables ...................................................................................... 36ms DONE

   INFO  Preparing database.

  Creating migration table ................................................................................. 16ms DONE

   INFO  Running migrations.

  2014_10_12_100000_create_password_resets_table ........................................................... 20ms DONE
  2019_08_19_000000_create_failed_jobs_table ............................................................... 19ms DONE
  2019_12_14_000001_create_personal_access_tokens_table .................................................... 27ms DONE
  2023_01_03_131155_create_roles_table ..................................................................... 13ms DONE
  2023_01_03_131203_create_divisions_table ................................................................. 41ms DONE
  2023_01_03_131204_create_users_table ..................................................................... 66ms DONE
  2023_01_03_131235_create_asset_categories_table .......................................................... 12ms DONE
  2023_01_03_131242_create_assets_table .................................................................... 85ms DONE
  2023_01_03_131243_create_pages_table ..................................................................... 13ms DONE
  2023_01_03_131244_create_role_page_mappings_table ........................................................ 59ms DONE
  2023_01_03_131317_create_deleted_assets_table ............................................................ 57ms DONE
  2023_01_03_131331_create_requests_table .................................................................. 79ms DONE
  2023_01_03_131343_create_bookings_table .................................................................. 85ms DONE
  2023_01_14_031259_create_repair_assets_table ............................................................. 52ms DONE
  2023_01_19_164853_create_asset_locations_table ........................................................... 61ms DONE
  2023_01_23_134454_create_locations_table ................................................................. 19ms DONE

   INFO  Seeding database.

  Database\Seeders\RoleSeeder ................................................................................ RUNNING
  Database\Seeders\RoleSeeder .......................................................................... 22.58 ms DONE

  Database\Seeders\DivisionSeeder ............................................................................ RUNNING
  Database\Seeders\DivisionSeeder ....................................................................... 4.56 ms DONE

  Database\Seeders\UserSeeder ................................................................................ RUNNING
  Database\Seeders\UserSeeder ......................................................................... 466.31 ms DONE

  Database\Seeders\AssetCategorySeeder ....................................................................... RUNNING
  Database\Seeders\AssetCategorySeeder .................................................................. 3.50 ms DONE

  Database\Seeders\AssetSeeder ............................................................................... RUNNING
  Database\Seeders\AssetSeeder .......................................................................... 4.44 ms DONE

  Database\Seeders\AssetLocationSeeder ....................................................................... RUNNING
  Database\Seeders\AssetLocationSeeder .................................................................. 3.83 ms DONE

  Database\Seeders\PageSeeder ................................................................................ RUNNING
  Database\Seeders\PageSeeder ........................................................................... 3.62 ms DONE

  Database\Seeders\RolePageMappingSeeder ..................................................................... RUNNING
  Database\Seeders\RolePageMappingSeeder ................................................................ 4.98 ms DONE

  Database\Seeders\RequestSeeder ............................................................................. RUNNING
  Database\Seeders\RequestSeeder ........................................................................ 2.42 ms DONE

  Database\Seeders\BookingSeeder ............................................................................. RUNNING
  Database\Seeders\BookingSeeder ........................................................................ 2.27 ms DONE

  Database\Seeders\LocationSeeder ............................................................................ RUNNING
  Database\Seeders\LocationSeeder ....................................................................... 3.03 ms DONE


D:\xampp\htdocs\asset-manager>composer dump-autoload
Generating optimized autoload files
Class App\Models\assetLocation located in D:/xampp/htdocs/asset-manager/app\Models\AssetLocation.php does not comply with psr-4 autoloading standard. Skipping.
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.

  codedge/laravel-fpdf .......................................................................................... DONE
  laravel/sail .................................................................................................. DONE
  laravel/sanctum ............................................................................................... DONE
  laravel/tinker ................................................................................................ DONE
  laravel/ui .................................................................................................... DONE
  maatwebsite/excel ............................................................................................. DONE
  nesbot/carbon ................................................................................................. DONE
  nunomaduro/collision .......................................................................................... DONE
  nunomaduro/termwind ........................................................................................... DONE
  spatie/laravel-ignition ....................................................................................... DONE

Generated optimized autoload files containing 6129 classes

D:\xampp\htdocs\asset-manager>
