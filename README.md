# Vanja Dunkel Portfolio CMS

A PHP 8+ and MySQL–based content management system for a personal portfolio website.  
Features include user registration/login, CRUD operations for projects, image uploads, a drag-and-drop “About” section
editor, responsive Tailwind CSS layouts, and a custom 404 page.

---

## Prerequisites

- **PHP** 8.0 or higher, with the PDO (MySQL) extension enabled
- **MySQL** or MariaDB server
- **Git** (to clone the repo)
- No additional PHP frameworks or composer dependencies

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/vanja_dunkel_portfolio_PHP.git
   cd vanja_dunkel_portfolio_PHP
   ```

2. **Create your database and import the schema**
   ```bash
   mysql -u root -p
   CREATE DATABASE wdd324_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT
   mysql -u root -p wdd324_demo < wdd324_demo.sql
   ```

3. **Configure database credentials**  
   Copy the example config and edit with your settings:
   ```bash
   cp app/core/config.example.php app/core/config.php
   ```
   In `app/core/config.php`, set:
   ```php
   return [
     'db_host' => '127.0.0.1',
     'db_name' => 'wdd324_demo',
     'db_user' => 'root',
     'db_pass' => 'your_db_password',
   ];
   ```

4. **Prepare the uploads directory**
   ```bash
   mkdir -p uploads
   chmod 775 uploads
   ```

5. **Start the PHP built-in server**
   ```bash
   php -S localhost:8000 router.php
   ```

---

## Usage

1. **Register a new user**  
   Visit `http://localhost:8000/register.php` and create an account.

2. **Login**  
   Go to `http://localhost:8000/login.php`.

3. **Dashboard**  
   After login, access the protected CMS at  
   `http://localhost:8000/dashboard.php`  
   – Add, edit or delete projects  
   – Upload project images via drag-and-drop form

4. **About Editor**  
   In the Dashboard header menu, click **Edit About** or go to  
   `http://localhost:8000/about_admin.php`  
   – Add/edit/delete “About” sections  
   – Drag-and-drop to save a new order

5. **Public Pages**
    - Home: `index.php`
    - Project details: `project.php?id=<PROJECT_ID>`
    - About: `about.php`
    - Contact form: `contact.php`
    - Legal / Impressum: `legal.php`

6. **404 Handling**  
   Any unknown URL (e.g. `/nope`) will render `404.php` with your custom “Page not found” message.

---

## Project Structure

```
/
├─ app/
│  ├─ Core/
│  │  ├─ Database.php
│  │  └─ config.example.php
│  ├─ Models/
│  │  ├─ User.php
│  │  ├─ Project.php
│  │  └─ AboutSection.php
│  └─ Views/
│     ├─ partials/
│     │  ├─ header.php
│     │  └─ footer.php
│     ├─ dashboard.view.php
│     └─ about_admin.view.php
├─ uploads/       
├─ router.php     
├─ 404.php        
├─ login.php
├─ register.php
├─ dashboard.php
├─ about_admin.php
├─ index.php
├─ project.php
├─ contact.php
├─ legal.php
├─ wdd324_demo.sql
└─ README.md
```

---

## Troubleshooting

- **Blank pages or parse errors**  
  Ensure `session_start()` or `declare(strict_types=1)` is at the very top of each PHP script before any output.
- **Database connection failures**  
  Double-check credentials in `app/core/config.php` and that MySQL is running.
- **File upload errors**  
  Confirm `uploads/` exists and is writable by your webserver user.
- **404 page not appearing**  
  Make sure you started the server with `router.php`:
  ```bash
  php -S localhost:8000 router.php
  ```

---
