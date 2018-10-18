# Laravel Scaffold
Scaffold with Laravel 5.7 to using like base for future projects.

![Laravel Scaffold](https://github.com/modulr/laravel-scaffold/blob/master/public/img/laravel-scaffold.jpg)


Demo _Comming soon..._

Documentation _Comming soon..._

## Requirements

https://laravel.com/docs/5.7#server-requirements


## Tutorial

https://medium.com/modulr/create-scaffold-with-laravel-5-7-f5ab353dff1c


## Install

#### Clone Repo

```
git clone https://github.com/modulr/laravel-scaffold.git
```

#### Depencencies

```
composer install
npm install
```


## Configuration

#### Generate .env file
```
cp .env.example .env
```

#### Database

```
# Create Data Base
mysql -u{user} -p{password}
mysql> create database modulr_laravel;
```

```
# Add params into .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-scaffold
DB_USERNAME=user
DB_PASSWORD=password
```

#### File System
```
# Add params into .env file
APP_URL=http://laravel-scaffold.test
FILESYSTEM_DRIVER=public
```

```
# Generate symbolic link to Storage
php artisan storage:link
```


## Run

```
# Migrations
php artisan migrate

# Seeder (optional)
php artisan db:seed

# Compiling assets
npm run dev

# Run serve
php artisan serve
```


## Modules

- Auth
  - Login
  - Register - generate avatar
  - Remember Password


- Profile
  - Edit Name, email - regenerate avatar
  - Change password
  - Upload & Restart Avatar


- Users & Roles --> _Comming soon..._


## Packages

##### Backend
- [Laravel Authentication](https://laravel.com/docs/5.7/authentication)
- [Laravolt Avatar](https://github.com/laravolt/avatar)
- [Intervention Image](http://image.intervention.io/)


##### Frontend
- [Laravel Frontend](https://laravel.com/docs/5.7/frontend)
- [Bootstrap 4](https://getbootstrap.com/)
- [Core UI](https://coreui.io/)
- [Fontawesome 5](https://fontawesome.com/)
- [Simple Line Icons](http://simplelineicons.com/)
- [Vue Toasted](https://shakee93.github.io/vue-toasted/)
- [Vue Clip](https://vueclip.adonisjs.com/)



## License
The MIT© License 2018 - Modulr.

---

> Developed with :bulb: :headphones: :beer: by [@alfredobarron](https://github.com/alfredobarron)
