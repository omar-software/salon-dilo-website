# Salon Dilo Website - Laravel Vue Full Stack Version

Full Stack web application for Salon Dilo, rebuilt as a second version using Laravel, Vue.js, MySQL, and Vite.

This project was originally a static PHP / HTML / CSS website.  
It has now been upgraded to a full stack application with an admin area for managing website content.

## Features

- Public Salon Dilo website
- Laravel backend
- Vue.js frontend
- MySQL database connection
- Admin login with database authentication
- Password hashing with Laravel Hash
- Protected admin area using sessions
- Dynamic header image loaded from MySQL
- Header image upload from admin panel
- Gallery images loaded from MySQL
- Add gallery images from admin panel
- Delete gallery images from admin panel
- Image upload to public/images
- Responsive design

## Tech Stack

- Laravel
- PHP
- Vue.js
- Vite
- MySQL
- HTML
- CSS
- JavaScript
- XAMPP
- Git / GitHub

## Project Structure

```text
app/
├── Http/Controllers/
│   ├── SettingsController.php
│   └── GalleryController.php
├── Models/
│   ├── Admin.php
│   └── GalleryImage.php

database/
├── migrations/

resources/
├── js/
│   ├── components/
│   │   └── App.vue
│   └── pages/
│       ├── HomePage.vue
│       ├── AdminLogin.vue
│       └── AdminPage.vue
├── css/
│   └── app.css
└── views/
    └── welcome.blade.php

public/
└── images/

routes/
└── web.php
```

## Local Setup

Install PHP dependencies:

```bash
composer install
```

Install Node dependencies:

```bash
npm install
```

Create environment file:

```bash
cp .env.example .env
```

Generate Laravel app key:

```bash
php artisan key:generate
```

Configure MySQL database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salon_delo
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

Start Laravel:

```bash
php artisan serve
```

Start Vite:

```bash
npm run dev
```

Open the public website:

```text
http://127.0.0.1:8000
```

## Admin Area

Admin login page:

```text
http://127.0.0.1:8000/admin-login
```

The admin account is stored in the database and uses a hashed password.

The admin area includes:

- Header image management
- Gallery image management
- Image upload
- Image deletion
- Protected access using Laravel sessions

## Database Tables

Main tables used in this project:

```text
admins
settings
gallery_images
```

## Version Note

This is the second version of the Salon Dilo project.

The first version was a static PHP / HTML / CSS website.  
This version was rebuilt as a full stack Laravel and Vue.js application for portfolio purposes.

## Author

Omar Mohamad-Ali