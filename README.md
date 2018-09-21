# Laravel Scaffold
Scaffold with Laravel 5.7 to using like base for future projects.


## Requirements

https://laravel.com/docs/5.7#server-requirements


## Install

```
git clone https://github.com/modulr/laravel-scaffold.git
```

#### Install Depencencies

```
composer install
npm install
```

#### Database

```
// Create Data Base
mysql -u{user} -p{password}
mysql> create database modulr_laravel;
```


```
// Add params into .env file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-scaffold
DB_USERNAME=user
DB_PASSWORD=password
```

## Run

```
// Migrations
php artisan migrate

// Seeder (optional)
php artisan db:seed

// Compiling assets
npm run dev

// Run serve
php artisan serve
```

## Tutorial/Documentation

https://medium.com/modulr/create-scaffold-with-laravel-5-7-f5ab353dff1c


## Modules

- Auth
- Users & Roles --> Comming soon...


## Packages

- [Laravel Authentication](https://laravel.com/docs/5.7/authentication)
- [Laravel Frontend](https://laravel.com/docs/5.7/frontend)
- [Vuejs](https://vuejs.org/)
- [Bootstrap 4](https://getbootstrap.com/)
- [Core UI](https://coreui.io/)
- [Fontawesome 5](https://fontawesome.com/)
- [simple-line-icons](http://simplelineicons.com/)



## License
The MIT© License 2018 - Modulr.
