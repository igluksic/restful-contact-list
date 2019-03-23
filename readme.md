## RESTfull contact list demo
By Igor Luksic

This is a demo interface to demonstrate fully REST powered contact book.

Features:

- custom written OAuth (not using Laravel passport)
- simple bootstrap interface
- decoupled API and UI code for easy re-use

##INSTALATION

```
clone this repo first
```

Set up your config (DB, etc...):
```$xslt
cp .env.example .env
```
Only DB access is mandatory

Aterwards we install dependencies, migrate the database and seed it
```$xslt
composer install
php artisan migrate
php artisan db:seed
php artisan key:generate
```

One user is readily available from initial seed:

```$xslt
U: igluksic@gmail.com 
P: 123456
```

More can be added via DB seed or manually in tinker:
```$xslt
php artisan tinker
use DB;
DB::table('users')->insert(['name' => 'Yourname', 'email'=> 'enter@email.here', 'password'=> app('hash')->make('enter.password')]);
```

Also note that you have to be able to resolve hostname for rest service to work.
If not done via DNS - use local hosts file (usually located at /etc/hosts)

##POWERED BY: 
<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
