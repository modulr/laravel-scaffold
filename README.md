# Laravel Scaffold
Scaffold made with Laravel 5.7 and VueJS to using like base for future projects.

![Laravel Scaffold](https://github.com/modulr/laravel-scaffold/blob/master/public/img/laravel-scaffold.jpg)


Demo & Documentation _coming soon..._

## Requirements

https://laravel.com/docs/5.7#server-requirements


## How to Created Laravel Scaffold (Tutorials)


- [Authentication](https://link.medium.com/YsYZ4TJ1wR)
- [Add CoreUI Template](https://link.medium.com/mlq1D5N1wR)
- [Create Profile module](https://link.medium.com/e8EbuVR1wR)
- Create Users management module __comig soon__
- Create Roles managment module __coming soon__


## Install

Clone Repo

```
git clone https://github.com/modulr/laravel-scaffold.git
```

Enter folder
```
cd laravel-scaffold
```

Install Depencencies
```
composer install
npm install
```


## Configuration

Generate .env file
```
cp .env.example .env
```

Generate APP_KEY
```
php artisan key:generate
```

Generate symbolic link to Storage
```
php artisan storage:link
```

Database

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

- Users management
    - List users
    - Update users
    - Delete users
 
- Roles management
    - List roles
    - Create roles and assign permissions
    - List of users than used role
    - Update role
    - Delete role


## Features

- Upload files [Vue Clip](https://vueclip.adonisjs.com/)
- Crop and resize images [Intervention Image](http://image.intervention.io/) 
- Create default Avatar [Laravolt Avatar](https://github.com/laravolt/avatar) 
- Notifications [Vue Toasted](https://shakee93.github.io/vue-toasted/)
- Friendly Format [vue-moment](https://github.com/brockpetrie/vue-moment#readme)
- Fancy MultiSelect [Vue-multiselect](https://vue-multiselect.js.org/)
- Template [Core UI](https://coreui.io/)
-Icons
    - [Fontawesome 5](https://fontawesome.com/)
    - [Simple Line Icons](http://simplelineicons.com/)
- Table
    - serverside rendering
    - Pagination
    - Sort
    - Search
    - Loading


## Packages

##### Backend

- [Laravel Authentication](https://laravel.com/docs/5.7/authentication)
- [Laravel Frontend](https://laravel.com/docs/5.7/frontend)
- [Bootstrap 4](https://getbootstrap.com/)



## License

The MIT© License 2018 - Modulr.

---

> Developed with :bulb: :headphones: :beer: by [@alfredobarron](https://github.com/alfredobarron)
