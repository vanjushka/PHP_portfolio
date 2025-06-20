<?php
declare(strict_types=1);

// 1) Bootstrap (starts session, sets SameSite cookie, etc)
require_once __DIR__ . '/app/bootstrap.php';

// 2) Send 404 status header
http_response_code(404);

// 3) Set a page title
$pageTitle = '404 — Page Not Found';

// 4) Render header partial (opens <main>)
require_once __DIR__ . '/app/Views/partials/header.php';
?>

    <main class="pt-20 flex items-center justify-center min-h-screen bg-black text-white px-4">
        <div class="text-center space-y-4">
            <h1 class="text-6xl font-bold">404</h1>
            <p class="text-xl text-grayish">Sorry, the page you’re looking for doesn’t exist.</p>
            <a href="index.php"
               class="inline-block mt-4 bg-accent text-black px-6 py-2 rounded hover:bg-opacity-90 transition">
                ← Back to Home
            </a>
        </div>
    </main>

<?php
// 5) Render footer partial (closes </main>, </body>, </html>)
require_once __DIR__ . '/app/Views/partials/footer.php';
