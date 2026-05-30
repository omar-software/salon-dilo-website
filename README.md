# Salon Dilo Website - Laravel Vue Full Stack Version

Full Stack web application for Salon Dilo, rebuilt as a second version using Laravel, Vue.js, MySQL, Vite, and Selenium.

This project was originally a static PHP / HTML / CSS website.  
It has now been upgraded to a full stack application with an admin area for managing website content, cleaner backend architecture, and automated tests.

## Features

- Public Salon Dilo website
- Laravel backend
- Vue.js frontend
- MySQL database connection
- Admin login with database authentication
- Password hashing with Laravel Hash
- Protected admin area using sessions
- Admin route protection with custom Laravel Middleware
- Form Request Validation for admin login
- Dynamic header image loaded from MySQL
- Header image upload from admin panel
- Gallery images loaded from MySQL
- Add gallery images from admin panel
- Delete gallery images from admin panel
- Image upload to public/images
- Service Layer for image upload and deletion logic
- AdminSeeder for creating the default admin account
- Database seeding for local setup
- Laravel Feature Tests for authentication and protected routes
- Selenium end-to-end tests
- Automated tests for admin login, logout, homepage, and gallery management
- Git branch and Pull Request workflow
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
- Selenium
- Node.js
- XAMPP
- Git / GitHub

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── SettingsController.php
│   │   └── GalleryController.php
│   ├── Middleware/
│   │   └── AdminAuthMiddleware.php
│   └── Requests/
│       └── AdminLoginRequest.php
├── Models/
│   ├── Admin.php
│   └── GalleryImage.php
└── Services/
    └── ImageService.php

database/
├── migrations/
└── seeders/
    ├── AdminSeeder.php
    └── DatabaseSeeder.php

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

tests/
└── Feature/
    └── AdminAuthTest.php

selenium-tests/
├── admin-login-test.js
├── admin-logout-test.js
├── home-page-test.js
├── admin-gallery-add-test.js
├── admin-gallery-delete-test.js
├── package.json
└── package-lock.json
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

Seed the default admin account:

```bash
php artisan db:seed
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

The default admin account can be created with the AdminSeeder using:

```bash
php artisan db:seed
```

The admin area includes:

- Header image management
- Gallery image management
- Image upload
- Image deletion
- Protected access using Laravel sessions and custom middleware

## Database Tables

Main tables used in this project:

```text
admins
settings
gallery_images
```

## Clean Code and Architecture

The project was refactored to improve maintainability and code structure.

Implemented improvements:

- Custom Laravel Middleware for protecting the admin area and admin API routes
- Form Request Validation for admin login input validation
- ImageService for central image upload and deletion logic
- Cleaner controllers with less duplicated file handling code
- AdminSeeder for creating the default admin account
- Separate testing database for automated Laravel tests
- Feature development using Git branches and Pull Requests

Main architecture parts:

```text
app/
├── Http/
│   ├── Middleware/
│   │   └── AdminAuthMiddleware.php
│   ├── Requests/
│   │   └── AdminLoginRequest.php
│   └── Controllers/
│       ├── SettingsController.php
│       └── GalleryController.php
├── Services/
│   └── ImageService.php
└── Models/
    ├── Admin.php
    └── GalleryImage.php
```

## Laravel Feature Tests

This project includes Laravel Feature Tests for authentication and protected routes.

Tested backend features:

- Guest users are redirected from the admin page to the login page
- Admin login succeeds with valid credentials
- Admin login fails with an incorrect password
- Protected gallery API cannot be accessed without admin login
- Admin login validation requires an email address
- Admin login validation requires a password

Run Laravel tests:

```bash
php artisan test --filter=AdminAuthTest
```

The tests use a separate MySQL test database:

```text
salon_delo_test
```

## Selenium Tests

This project includes Selenium end-to-end tests for the main application features.

Tested features:

- Admin login
- Admin logout
- Public homepage content
- Gallery image upload
- Gallery image deletion

Test files:

```text
selenium-tests/
├── admin-login-test.js
├── admin-logout-test.js
├── home-page-test.js
├── admin-gallery-add-test.js
└── admin-gallery-delete-test.js
```

Install Selenium test dependencies:

```bash
cd selenium-tests
npm install
```

Run tests:

```bash
node admin-login-test.js
node home-page-test.js
node admin-gallery-add-test.js
node admin-gallery-delete-test.js
node admin-logout-test.js
```

Before running the tests, make sure Apache, MySQL, Laravel, and Vite are running.

Required local services:

```text
XAMPP Apache
XAMPP MySQL
php artisan serve
npm run dev
```

## Version Note

This is the second version of the Salon Dilo project.

The first version was a static PHP / HTML / CSS website.  
This version was rebuilt as a full stack Laravel and Vue.js application with middleware, validation, service layer, database seeding, Laravel Feature Tests, and Selenium end-to-end tests for portfolio purposes.

## License

This project is licensed under the MIT License.

## Author

Omar Mohamad-Ali