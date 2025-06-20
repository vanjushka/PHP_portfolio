<?php require __DIR__ . '/partials/header.php'; ?>

<main class="pt-20 max-w-5xl mx-auto px-4 space-y-10">

    <h1 class="text-3xl font-bold text-white text-center">Welcome to your Dashboard</h1>

    <!-- Add New Project Form -->
    <form action="" method="post" enctype="multipart/form-data"
          class="bg-gray-900 p-6 rounded-lg border border-gray-700 space-y-6">

        <h2 class="text-2xl font-semibold text-white">Add New Project</h2>

        <!-- Error Message -->
        <?php if (!empty($errormessage)): ?>
            <div class="p-4 bg-red-800 text-white rounded-lg border border-red-700">
                <?= htmlspecialchars($errormessage) ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (!empty($successmessage)): ?>
            <div class="p-4 bg-green-800 text-white rounded-lg border border-green-700">
                <?= htmlspecialchars($successmessage) ?>
            </div>
        <?php endif; ?>

        <div>
            <label for="title" class="block mb-1 text-gray-300">Project Title</label>
            <input type="text" name="title" id="title" required
                   class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
        </div>

        <div>
            <label for="description" class="block mb-1 text-gray-300">Description</label>
            <textarea name="description" id="description" rows="3" required
                      class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
        </div>

        <div>
            <label for="company" class="block mb-1 text-gray-300">Company Name</label>
            <input type="text" name="company" id="company"
                   class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
        </div>

        <div>
            <label for="link" class="block mb-1 text-gray-300">External Link</label>
            <input type="url" name="link" id="link"
                   class="w-full px-4 py-2 bg-black text-white border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
        </div>

        <div>
            <label class="block mb-1 text-gray-300">Upload Image</label>
            <div id="dropzone"
                 class="w-full h-32 flex flex-col items-center justify-center border-2 border-dashed border-gray-700 rounded cursor-pointer bg-black text-gray-500 hover:border-accent transition">
                <p>Drag & drop an image here, or click to select</p>
                <input type="file" name="image" id="image" accept="image/*" class="hidden"/>
            </div>
            <p id="filename" class="mt-2 text-sm text-gray-400"></p>
        </div>

        <button type="submit"
                class="w-full bg-accent text-black font-semibold py-2 rounded hover:bg-opacity-90 transition">
            Add Project
        </button>

    </form>

    <!-- Your Projects -->
    <?php if (!empty($projects)): ?>
        <section class="space-y-6 mt-12">
            <h2 class="text-2xl font-semibold text-white text-center">Your Projects</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($projects as $project): ?>
                    <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 flex flex-col justify-between">
                        <?php if (!empty($project['image'])): ?>
                            <img src="<?= htmlspecialchars($project['image']) ?>"
                                 alt="<?= htmlspecialchars($project['title']) ?>"
                                 class="w-full h-48 object-cover rounded mb-4"/>
                        <?php endif; ?>

                        <div>
                            <h3 class="text-lg font-bold text-white"><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="text-gray-400 mb-2"><?= htmlspecialchars($project['description']) ?></p>
                            <?php if (!empty($project['company'])): ?>
                                <p class="text-sm text-gray-500">
                                    Company: <?= htmlspecialchars($project['company']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['link'])): ?>
                                <a href="<?= htmlspecialchars($project['link']) ?>"
                                   class="text-accent underline text-sm" target="_blank" rel="noopener noreferrer">
                                    Visit project
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <form action="delete_project.php" method="post" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?= $project['id'] ?>"/>
                                <button type="submit" class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                            </form>
                            <a href="edit_project.php?id=<?= $project['id'] ?>"
                               class="text-accent hover:text-white text-sm">Edit</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>

<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('image');
    const filenameDisplay = document.getElementById('filename');

    dropzone.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => {
        filenameDisplay.textContent = fileInput.files[0]?.name || '';
    });

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, e => {
            e.preventDefault();
            dropzone.classList.toggle('border-accent', evt !== 'dragleave');
        });
        if (evt === 'drop') {
            dropzone.addEventListener('drop', e => {
                fileInput.files = e.dataTransfer.files;
                filenameDisplay.textContent = e.dataTransfer.files[0]?.name || '';
            });
        }
    });
</script>
