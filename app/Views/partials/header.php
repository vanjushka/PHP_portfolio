<?php
declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?= htmlspecialchars($pageTitle ?? 'Vanja Dunkel Portfolio') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#333333',
                        medium: '#555555',
                        accent: '#f0630c',
                        grayish: '#c2bebe',
                        border: '#cccccc',
                        bgSoft: '#D1D1D1',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-black text-white font-sans antialiased">

<header class="fixed inset-x-0 top-0 z-50 bg-black border-b border-medium">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <a href="index.php" class="text-3xl font-extrabold tracking-wide">VD</a>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center space-x-8 text-lg">
            <a href="index.php" class="px-4 py-2 text-grayish hover:text-white transition">Work</a>
            <a href="about.php" class="px-4 py-2 text-grayish hover:text-white transition">About</a>
            <a href="contact.php" class="px-4 py-2 text-grayish hover:text-white transition">Contact</a>
            <a href="legal.php" class="px-4 py-2 text-grayish hover:text-white transition">Legal</a>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="px-4 py-2 text-grayish hover:text-white transition">Dashboard</a>
                <a href="about_admin.php" class="px-4 py-2 text-grayish hover:text-white transition">Edit About</a>
                <a href="logout.php" class="px-4 py-2 text-grayish hover:text-white transition">Logout</a>
            <?php else: ?>
                <a href="login.php"
                   class="px-4 py-2 font-semibold border border-grayish rounded text-grayish hover:bg-grayish hover:text-black transition">
                    Login
                </a>
            <?php endif; ?>
        </nav>

        <!-- Mobile Toggle -->
        <button id="nav-toggle" class="lg:hidden p-2 text-grayish focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="hidden lg:hidden bg-black border-t border-medium">
        <div class="px-6 py-4 space-y-4 text-lg">
            <a href="index.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Work</a>
            <a href="about.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">About</a>
            <a href="contact.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Contact</a>
            <a href="legal.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Legal</a>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Dashboard</a>
                <a href="about_admin.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Edit
                    About</a>
                <a href="logout.php" class="block px-4 py-3 text-grayish hover:text-white rounded transition">Logout</a>
            <?php else: ?>
                <a href="login.php"
                   class="block px-4 py-3 text-grayish border border-grayish rounded hover:bg-grayish hover:text-black transition">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="pt-20">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('nav-toggle');
            const menu = document.getElementById('mobile-menu');
            btn.addEventListener('click', () => menu.classList.toggle('hidden'));
        });
    </script>
