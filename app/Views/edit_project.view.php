<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Project — <?= htmlspecialchars($project['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white min-h-screen px-4 py-10">

<div class="max-w-3xl mx-auto space-y-6">
    <h1 class="text-3xl font-bold text-center">Edit Project</h1>

    <?php if (!empty($errormessage)): ?>
        <div class="p-4 bg-red-800 rounded"><?= htmlspecialchars($errormessage) ?></div>
    <?php endif; ?>
    <?php if (!empty($successmessage)): ?>
        <div class="p-4 bg-green-800 rounded"><?= htmlspecialchars($successmessage) ?></div>
    <?php endif; ?>

    <form
            action="edit_project.php?id=<?= $project['id'] ?>"
            method="post"
            enctype="multipart/form-data"
            class="bg-neutral-900 p-6 rounded-lg border border-gray-700 space-y-6"
    >
        <!-- Title -->
        <div>
            <label for="title" class="block mb-1 text-gray-300">Project Title</label>
            <input
                    type="text"
                    id="title"
                    name="title"
                    required
                    value="<?= htmlspecialchars($project['title']) ?>"
                    class="w-full px-4 py-2 bg-black text-white border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block mb-1 text-gray-300">Description</label>
            <textarea
                    id="description"
                    name="description"
                    rows="4"
                    required
                    class="w-full px-4 py-2 bg-black text-white border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            ><?= htmlspecialchars($project['description']) ?></textarea>
        </div>

        <!-- Company -->
        <div>
            <label for="company" class="block mb-1 text-gray-300">Company</label>
            <input
                    type="text"
                    id="company"
                    name="company"
                    value="<?= htmlspecialchars($project['company'] ?? '') ?>"
                    class="w-full px-4 py-2 bg-black text-white border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <!-- External Link -->
        <div>
            <label for="link" class="block mb-1 text-gray-300">External Link</label>
            <input
                    type="url"
                    id="link"
                    name="link"
                    value="<?= htmlspecialchars($project['link'] ?? '') ?>"
                    class="w-full px-4 py-2 bg-black text-white border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <!-- Current Image & Delete -->
        <?php if (!empty($project['image'])): ?>
            <div class="space-y-2">
                <img
                        src="<?= htmlspecialchars($project['image']) ?>"
                        alt="Current Project Image"
                        class="w-full h-48 object-cover rounded"
                />
                <div class="flex items-center space-x-2">
                    <input
                            type="checkbox"
                            id="delete_image"
                            name="delete_image"
                            value="1"
                            class="h-4 w-4 text-red-600 bg-black border-gray-600 rounded focus:ring-red-500"
                    />
                    <label for="delete_image" class="text-gray-300">
                        Remove current image
                    </label>
                </div>
            </div>
        <?php endif; ?>

        <!-- Upload New Image -->
        <div>
            <label for="image" class="block mb-1 text-gray-300">Upload New Image</label>
            <input
                    type="file"
                    id="image"
                    name="image"
                    class="w-full text-gray-300"
            />
        </div>

        <!-- Save Button -->
        <button
                type="submit"
                class="w-full bg-white text-black font-semibold py-2 rounded hover:bg-gray-200 transition"
        >
            Save Changes
        </button>
    </form>

    <div class="text-center">
        <a
                href="dashboard.php"
                class="text-blue-400 underline hover:text-blue-600"
        >
            Back to Dashboard
        </a>
    </div>
</div>

</body>
</html>
