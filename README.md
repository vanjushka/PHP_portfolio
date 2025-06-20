# PHP CMS Portfolio Project

## Project Overview

This project is a PHP 8+ & MySQL based Content Management System (CMS) application. Registered users can create, read,
update, and delete (CRUD) content items such as projects and an About section. The frontend uses Tailwind CSS for a
fully responsive design, and light JavaScript enhances the user experience.

## Features

- User registration & login using `password_hash()` and `password_verify()`
- CRUD operations for content types (e.g., Projects, About section) via PDO (prepared statements)
- Image file uploads to `/uploads` (publicly accessible)
- CSRF protection via `SameSite=Strict` session cookie
- XSS protection using `htmlspecialchars()` on all outputs
- 404 error page for invalid URLs
- PSR-4 autoloading for `App\` namespace classes
- Full type declarations for method parameters, return types, and properties
- Responsive design with Tailwind CSS

## Requirements

- PHP 8.0 or higher
- MySQL
- A web server (Apache, Nginx) or PHP built-in server

## Installation

1. **Clone or extract the project**
   ```bash
   git clone <repository-url> my-php-cms
   cd my-php-cms
   ```

2. **Create configuration file**  
   Copy `config/config.example.php` to `config/config.php` and adjust database credentials:
   ```php
   <?php
   return [
       'db_host' => 'localhost',
       'db_name' => 'mydb',
       'db_user' => 'root',
       'db_pass' => 'secret',
   ];
   ```

3. **Import the database**
   ```bash
   mysql -u root -p mydb < wdd324_demo.sql
   ```

4. **Set up the web server**
    - Point the document root to the project folder (e.g., `localhost:8080`).
    - Ensure `bootstrap.php` is included at the top of every entry script.

5. **Dependencies**  
   No external PHP dependencies. Tailwind CSS is prebuilt.

## Usage

1. **Register a new user**  
   Visit `/register.php`, fill in a username, email, and password, and submit the form to create an account.

2. **Log in**  
   Go to `/login.php`, enter your credentials, and submit to access the dashboard.

3. **Manage content**
    - Create, edit, or delete projects on the dashboard (`/dashboard.php`).
    - Update the About section on `/about_admin.php`.
    - Use the contact form at `/contact.php`.

## CSRF Protection

We protect against cross-site request forgery by setting our session cookie with `SameSite=Strict`. In `bootstrap.php`:

```php
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => $_SERVER['HTTP_HOST'],
    'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_name('mys_session');
session_start();
```

## Project Structure

```
/app
  /Core        # Bootstrap, Router, utilities
  /Controllers # Controller classes
  /Models      # Database models
/config        # Configuration files
/public        # Public assets (CSS, JS, uploads)
/uploads       # Uploaded files
/index.php     # Front controller
bootstrap.php  # Initialization (session, autoloader)
/wdd324_demo.sql # Database dump
README.md      # Project documentation
```
