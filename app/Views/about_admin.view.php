<?php require __DIR__ . '/partials/header.php'; ?>

<main class="pt-20 max-w-5xl mx-auto px-4 space-y-8">

    <h1 class="text-3xl font-bold text-white text-center">Manage About Sections</h1>

    <!-- Feedback Messages -->
    <?php if ($err): ?>
        <div class="p-4 bg-red-800 text-white rounded-lg border border-red-700">
            <?= htmlspecialchars($err) ?>
        </div>
    <?php endif; ?>
    <?php if ($succ): ?>
        <div class="p-4 bg-green-800 text-white rounded-lg border border-green-700">
            <?= htmlspecialchars($succ) ?>
        </div>
    <?php endif; ?>

    <!-- Add / Edit Form -->
    <form method="post"
          enctype="multipart/form-data"
          class="bg-gray-900 p-6 rounded-lg border border-gray-700 space-y-6">

        <input type="hidden" name="id" value="<?= htmlspecialchars($editing['id'] ?? '') ?>">

        <div>
            <label class="block text-white mb-1">Title</label>
            <input type="text"
                   name="title"
                   value="<?= htmlspecialchars($editing['title'] ?? '') ?>"
                   class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:ring-2 focus:ring-blue-500"/>
        </div>

        <div>
            <label class="block text-white mb-1">Content</label>
            <textarea name="content" rows="4"
                      class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($editing['content'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-white mb-1">Image</label>
            <input type="file" name="image"
                   class="w-full text-gray-300 bg-black border border-gray-700 rounded px-3 py-2"/>
            <?php if (!empty($editing['image'])): ?>
                <div class="mt-3 flex items-center space-x-3">
                    <img src="<?= htmlspecialchars($editing['image']) ?>"
                         alt=""
                         class="h-24 w-auto object-cover rounded border border-gray-700"/>
                    <label class="inline-flex items-center text-white">
                        <input type="checkbox" name="delete" value="1"
                               class="mr-2 h-4 w-4 text-red-600 bg-black border-gray-700 rounded"/>
                        Remove image
                    </label>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit"
                class="w-full bg-white text-black font-semibold py-2 rounded hover:bg-gray-200 transition">
            <?= isset($editing) ? 'Update Section' : 'Add Section' ?>
        </button>
    </form>

    <!-- Reorder Button -->
    <div class="text-right">
        <button id="save-order"
                class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200 transition">
            Save New Order
        </button>
    </div>

    <!-- Draggable Cards -->
    <div id="sections-list"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($sections as $sec): ?>
            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 flex flex-col"
                 data-id="<?= $sec['id'] ?>">
                <?php if ($sec['image']): ?>
                    <img src="<?= htmlspecialchars($sec['image']) ?>"
                         alt=""
                         class="w-full h-32 object-cover rounded mb-4"/>
                <?php endif; ?>

                <?php if (!empty(trim($sec['title']))): ?>
                    <h3 class="text-white font-semibold mb-2"><?= htmlspecialchars($sec['title']) ?></h3>
                <?php endif; ?>
                <?php if (!empty(trim($sec['content']))): ?>
                    <p class="text-gray-300 flex-grow"><?= nl2br(htmlspecialchars($sec['content'])) ?></p>
                <?php endif; ?>

                <div class="mt-4 flex justify-between items-center">
                    <a href="?id=<?= $sec['id'] ?>"
                       class="text-blue-400 hover:text-white text-sm">
                        Edit
                    </a>
                    <form method="post"
                          onsubmit="return confirm('Delete this section?');"
                          class="inline">
                        <input type="hidden" name="id" value="<?= $sec['id'] ?>"/>
                        <input type="hidden" name="delete" value="1"/>
                        <button type="submit" class="text-red-400 hover:text-red-600 text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>

<!-- SortableJS & Reorder Logic -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const list = document.getElementById('sections-list');
    Sortable.create(list, {animation: 150});

    document.getElementById('save-order').addEventListener('click', () => {
        const ids = Array.from(list.children).map(el => el.dataset.id);
        const form = document.createElement('form');
        form.method = 'post';
        form.style.display = 'none';
        // include action indicator
        form.innerHTML = '<input name="action" value="reorder"/>' +
            ids.map(id => `<input name="order[]" value="${id}">`).join('');
        document.body.appendChild(form);
        form.submit();
    });
</script>
