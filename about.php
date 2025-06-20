<?php
declare(strict_types=1);

// 1) Page Title
$pageTitle = 'About — Vanja Dunkel';

// 2) Bootstrap & DB model
require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/AboutSection.php';

use App\Models\AboutSection;

// 3) Fetch dynamic sections
$sections = (new AboutSection())->getAll();

// 4) Render header (opens <main>)
require __DIR__ . '/app/Views/partials/header.php';
?>

<!-- Hero Banner -->
<section class="bg-primary py-16">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
        <h1 class="text-4xl font-bold text-white">Vanja Dunkel</h1>
        <p class="text-lg text-grayish">Graphic Designer.</p>
        <div class="flex justify-center space-x-6 text-4xl">
            <span role="img" aria-label="Paint palette">🎨</span>
            <span role="img" aria-label="Laptop">💻</span>
            <span role="img" aria-label="Ruler">📐</span>
        </div>
    </div>
</section>

<!-- Dynamic Sections Grid -->
<section class="max-w-6xl mx-auto px-4 py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($sections as $sec):
        $hasTitle = !empty(trim($sec['title'] ?? ''));
        $hasContent = !empty(trim($sec['content'] ?? ''));
        $hasImage = !empty(trim($sec['image'] ?? ''));
        ?>
        <div class="bg-dark rounded-lg border border-medium shadow-lg overflow-hidden">
            <?php if ($hasImage): ?>
                <div class="p-2">
                    <img
                            src="<?= htmlspecialchars($sec['image']) ?>"
                            alt="<?= htmlspecialchars($sec['title'] ?? '') ?>"
                            class="w-full h-auto object-contain sm:h-48 sm:object-cover md:h-64 lg:h-72 rounded-lg"
                    />
                </div>
            <?php endif; ?>

            <?php if ($hasTitle || $hasContent): ?>
                <div class="p-6">
                    <?php if ($hasTitle): ?>
                        <h3 class="text-2xl font-semibold text-white mb-2">
                            <?= htmlspecialchars($sec['title']) ?>
                        </h3>
                    <?php endif; ?>
                    <?php if ($hasContent): ?>
                        <p class="text-grayish">
                            <?= nl2br(htmlspecialchars($sec['content'])) ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>

<?php
// 5) Render footer (closes </main>, </body>, </html>)
require __DIR__ . '/app/Views/partials/footer.php';
?>
