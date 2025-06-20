# Vanja Dunkel Portfolio CMS

A PHP 8+ and MySQL–based content management system for a personal portfolio website.  
Features include user registration/login, CRUD operations for projects, image uploads, a drag-and-drop “About” section
editor, responsive Tailwind CSS layouts, and a custom 404 page.

---

## Prerequisites

- **PHP** 8.0 or higher, with the PDO (MySQL) extension enabled
- **MySQL** or MariaDB server
- **Git** (to clone the repo)
- No additional PHP frameworks or Composer dependencies

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/vanja_dunkel_portfolio_PHP.git
   cd vanja_dunkel_portfolio_PHP
   ```

2. **Create your database and import the schema**
   ```sql
   mysql -u root -p
   CREATE DATABASE wdd324_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT
   mysql -u root -p wdd324_demo < wdd324_demo.sql
   ```

3. **Configure database credentials**  
   Copy the example config into `config/` and adjust to your own credentials:
   ```bash
   cp config/config.example.php config/config.php
   ```
   Then edit `config/config.php` to something like:
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
   Visit: `http://localhost:8000/register.php`

2. **Login**  
   Visit: `http://localhost:8000/login.php`

3. **Dashboard (protected)**  
   After login, go to: `http://localhost:8000/dashboard.php`
    - Add, edit, or delete projects
    - Drag-and-drop image upload

4. **About Editor**  
   From the Dashboard nav click **Edit About** or visit:  
   `http://localhost:8000/about_admin.php`
    - Add/edit/delete “About” sections
    - Drag-and-drop to reorder

5. **Public Pages**
    - Home: `index.php`
    - Project details: `project.php?id=<PROJECT_ID>`
    - About: `about.php`
    - Contact form: `contact.php`
    - Legal / Impressum: `legal.php`

6. **404 Handling**  
   Unknown URLs render `404.php` when you run with `router.php`:
   ```bash
   php -S localhost:8000 router.php
   ```

---

## Project Structure

```
/
├─ app/
│  ├─ Core/
│  │  ├─ Database.php
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
├─ config/
│  ├─ config.example.php
│  └─ config.php         
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
  Make sure `declare(strict_types=1)` and `session_start()` (via `app/bootstrap.php`) appear before any HTML output.

- **Database connection failures**  
  Double-check your credentials in `config/config.php` and that MySQL is running.

- **File upload errors**  
  Ensure `uploads/` exists and is writable by your webserver user.

- **404 page not appearing**  
  Be sure to start your server with:
  ```bash
  php -S localhost:8000 router.php
  ```

---
