<?php
declare(strict_types=1);

// 1) Seitentitel
$pageTitle = 'Home — Vanja Dunkel';

// 2) Header‐Partial laden (<html><head>…<body><main>)
require __DIR__ . '/app/Views/partials/header.php';

// 3) DB & Model
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';

use App\Models\Project;

// 4) Projekte holen
$projects = (new Project())->getAll();
?>

<!-- Hero / Intro mit Spline -->
<section class="bg-black text-center pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4 space-y-4">
        <h1 class="text-5xl font-bold text-white">Vanja Dunkel</h1>
        <p class="text-lg text-gray-300">Building with purpose, designing with edge.</p>
    </div>
    <div class="mt-12 flex justify-center px-4">
        <script type="module"
                src="https://unpkg.com/@splinetool/viewer@1.10.12/build/spline-viewer.js">
        </script>
        <spline-viewer
                url="https://prod.spline.design/kr5pzUI0YfSr7WzC/scene.splinecode"
                class="w-full max-w-4xl h-96">
        </spline-viewer>
    </div>
</section>

<!-- My Work Überschrift -->
<section class="mt-20 text-center">
    <h2 class="text-2xl text-gray-400">My Work</h2>
</section>

<!-- ========== Dynamische Projekt‐Cards (80% auf Großbild, 90% auf Tablet) ========== -->
<div class="w-full sm:w-[90%] lg:w-[80%] mx-auto mt-8 space-y-8 px-4">
    <?php foreach ($projects as $idx => $p): ?>
        <div class="bg-dark border border-medium rounded-lg shadow-lg overflow-hidden flex flex-col lg:flex-row">
            <!-- Bild & Meta -->
            <div class="relative w-full lg:w-1/2 h-64">
                <div class="absolute top-4 left-4 flex space-x-2 text-xs text-grayish uppercase">
                    <span><?= sprintf('%02d', $idx + 1) ?></span>
                    <span><?= htmlspecialchars($p['company'] ?: 'UI/UX Designer') ?></span>
                </div>
                <img src="<?= htmlspecialchars($p['image'] ?? 'assets/imgs/placeholder.png') ?>"
                     alt="<?= htmlspecialchars($p['title']) ?>"
                     class="object-cover w-full h-full"/>
            </div>

            <!-- Text & Button -->
            <div class="p-6 flex flex-col justify-center w-full lg:w-1/2 space-y-4">
                <h3 class="text-2xl font-semibold text-white">
                    <?= htmlspecialchars($p['title']) ?>
                </h3>
                <p class="text-grayish">
                    <?= htmlspecialchars($p['description']) ?>
                </p>
                <a href="project.php?id=<?= $p['id'] ?>"
                   class="inline-block px-4 py-2 border border-medium rounded text-white hover:bg-gray-800">
                    View Project
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
// Footer‐Partial (<footer></body></html>)
require __DIR__ . '/app/Views/partials/footer.php';
?>
