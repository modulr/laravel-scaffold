# Laravel Scaffold
Created with Laravel 5.7 and VueJS. Code free.

### Table of Contents

- [Demo](#demo)
- [Features](#features)
- [Tutorials](#tutorials)
- [Installation](#installation)
- [Documentation](#documentation)
- [Modules](#modules)
  - Auth
  - Users
  - Roles&Permissions 
  - Profile


![Laravel Scaffold](https://github.com/modulr/laravel-scaffold/blob/master/public/img/laravel-scaffold.jpg)


## Demo
**coming soon**

## Features

- [Laravel Authentication](https://laravel.com/docs/5.7/authentication) Auth
- [laravel-permission](https://github.com/spatie/laravel-permission) Roles & Permissions 
- [Laravel Frontend](https://laravel.com/docs/5.7/frontend)
- [Bootstrap 4](https://getbootstrap.com/)
- [Core UI](https://coreui.io/) Template
- Icons
    - [Fontawesome 5](https://fontawesome.com/)
    - [Simple Line Icons](https://github.com/thesabbir/simple-line-icons)
- [Vue Clip](https://vueclip.adonisjs.com/) Upload files
- [Intervention Image](http://image.intervention.io/)  Crop and resize images 
- [Laravolt Avatar](https://github.com/laravolt/avatar) Create default avatar 
- [Vue-multiselect](https://vue-multiselect.js.org/) Fancy multiselect 
- [Sweat Alert](https://sweetalert.js.org/) Alerts 
- [Vue Toasted](https://shakee93.github.io/vue-toasted/) Notifications
- [vue-moment](https://github.com/brockpetrie/vue-moment#readme) Friendly date format 
- [vue-content-placeholders](https://github.com/michalsnik/vue-content-placeholders) Rendering fake progressive content
- Table
    - Serverside rendering
    - Pagination
    - Sort
    - Search
    
    
## Tutorials

#### How to created Laravel Scaffold


- [Authentication](https://link.medium.com/YsYZ4TJ1wR)
- [Add CoreUI Template](https://link.medium.com/mlq1D5N1wR)
- [Create Profile module](https://link.medium.com/e8EbuVR1wR)
- Create Users management module -> _comig soon..._
- Create Roles managment module -> _coming soon..._


## Installation 


### Requirements

https://laravel.com/docs/5.7#server-requirements


#### Clone Repo

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


#### Configuration

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

#### Run

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
## Documentation 
**coming soon**

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
    - Create user
    - Update users
    - Delete users
 
- Roles & Permission management
    - List roles
    - Create roles and assign permissions
    - Update role and permissions
    - Users list who use the role
    - Delete role
   

## License

The MIT© License 2018 - Modulr.

---

> Developed with :bulb: :headphones: :beer: by [@alfredobarron](https://github.com/alfredobarron)
