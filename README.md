# Laravel Scaffold
Scaffold made with Laravel 5.7 and VueJS to using like base for future projects.

![Laravel Scaffold](https://github.com/modulr/laravel-scaffold/blob/master/public/img/laravel-scaffold.jpg)


Demo & Documentation _coming soon..._

## Requirements

https://laravel.com/docs/5.7#server-requirements


## Tutorial 

### How to Create


[Authentication](Create Scaffold with Laravel 5.7 — Authentication (Part 1) by Alfredo Barron https://link.medium.com/YsYZ4TJ1wR)
[Add CoreUI Template](Create Scaffold with Laravel 5.7 — Add Core UI Template (Part 2) by Alfredo Barron https://link.medium.com/mlq1D5N1wR)
[Create Profile module](Create Scaffold with Laravel 5.7 — Profile (Part 3.1) Edit profile by Alfredo Barron https://link.medium.com/e8EbuVR1wR)
Create Users management module __comig soon__
Create Roles managment module __coming soon__




https://medium.com/modulr/create-scaffold-with-laravel-5-7-f5ab353dff1c


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
    - Create users
    - Read users list into reusable table with paginate, sort, search and loading feature**
    - Update users
    - Delete users
 
- Roles management
    - List roles
    - Create roles and assign permissions
    - List of users than used role
    - Update role
    - Delete role


## Features

- Table
    - serverside rendering
    - Pagination
    - Sort
    - Search
    - Loading


## Packages

##### Backend

- [Laravel Authentication](https://laravel.com/docs/5.7/authentication)
- [Laravolt Avatar](https://github.com/laravolt/avatar) Create default Avatar
- [Intervention Image](http://image.intervention.io/) Crop and resize images


##### Frontend

- [Laravel Frontend](https://laravel.com/docs/5.7/frontend)
- [Bootstrap 4](https://getbootstrap.com/)
- [Core UI](https://coreui.io/) Template
Icons
- [Fontawesome 5](https://fontawesome.com/)
- [Simple Line Icons](http://simplelineicons.com/)
- [Vue Toasted](https://shakee93.github.io/vue-toasted/) Notifications
- [Vue Clip](https://vueclip.adonisjs.com/) Upload files
- [vue-moment](https://github.com/brockpetrie/vue-moment#readme) Friendly Format Dates
- [Vue-multiselect](https://vue-multiselect.js.org/) Fancy MultiSelect 



## License

The MIT© License 2018 - Modulr.

---

> Developed with :bulb: :headphones: :beer: by [@alfredobarron](https://github.com/alfredobarron)
