<?php
// app/Views/partials/header.php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                        bgSoft: '#D1D1D1'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-black text-white font-sans antialiased">

<!-- Header / Navbar -->
<header class="fixed inset-x-0 top-0 z-50 bg-black border-b border-medium">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
        <!-- Logo -->
        <a href="index.php" class="text-3xl font-extrabold tracking-wider px-4 py-2">VD</a>

        <!-- Desktop Nav: larger text on laptop/fullscreen -->
        <nav class="hidden lg:flex items-center space-x-6">
            <a href="index.php"
               class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                Work
            </a>
            <a href="about.php"
               class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                About
            </a>
            <a href="contact.php"
               class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                Contact
            </a>
            <a href="legal.php"
               class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                Legal
            </a>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="dashboard.php"
                   class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                    Dashboard
                </a>
                <a href="about_admin.php"
                   class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                    Edit About
                </a>
                <a href="logout.php"
                   class="px-3 py-2 text-lg lg:text-xl text-grayish hover:text-white">
                    Logout
                </a>
            <?php else: ?>
                <a href="login.php"
                   class="ml-4 px-4 py-2 text-lg lg:text-xl font-semibold border border-grayish rounded text-grayish hover:bg-grayish hover:text-black transition">
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
        <div class="px-4 py-6 space-y-6">
            <a href="index.php"
               class="block px-6 py-3 text-grayish hover:text-white rounded">Work</a>
            <a href="about.php"
               class="block px-6 py-3 text-grayish hover:text-white rounded">About</a>
            <a href="contact.php"
               class="block px-6 py-3 text-grayish hover:text-white rounded">Contact</a>
            <a href="legal.php"
               class="block px-6 py-3 text-grayish hover:text-white rounded">Legal</a>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="dashboard.php"
                   class="block px-6 py-3 text-grayish hover:text-white rounded">Dashboard</a>
                <a href="about_admin.php"
                   class="block px-6 py-3 text-grayish hover:text-white rounded">Edit About</a>
                <a href="logout.php"
                   class="block px-6 py-3 text-grayish hover:text-white rounded">Logout</a>
            <?php else: ?>
                <a href="login.php"
                   class="block px-6 py-3 text-grayish border border-grayish rounded hover:bg-grayish hover:text-black transition">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<!-- Push content below the header -->
<main class="pt-16">
    <script>
        document.getElementById('nav-toggle').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
