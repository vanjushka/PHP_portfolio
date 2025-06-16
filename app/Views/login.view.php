<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen">

<form action="" method="post" class="bg-black shadow-lg rounded-lg p-8 w-full max-w-md space-y-6">

    <!-- Show Error Message -->
    <?php if (!empty($errormessage)): ?>
        <div class="text-red-500 mb-4"><?= htmlspecialchars($errormessage) ?></div>
    <?php endif; ?>

    <!-- Show Success Message (optional) -->
    <?php if (!empty($successmessage)): ?>
        <div class="text-green-500 mb-4"><?= htmlspecialchars($successmessage) ?></div>
    <?php endif; ?>

    <!-- Email -->
    <div>
        <label for="email" class="block text-white font-semibold mb-1">Email</label>
        <input type="email" placeholder="Enter Email" name="email" required
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
               value="<?= htmlspecialchars($email ?? '') ?>">
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-white font-semibold mb-1">Password</label>
        <input type="password" placeholder="Enter Password" name="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Remember me + Login button -->
    <div class="flex items-center justify-between">
        <label class="flex items-center">
            <input type="checkbox" checked="checked" name="remember" class="mr-2">
            <span class="text-sm text-white">Remember me</span>
        </label>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Login
        </button>
    </div>

    <!-- Cancel + Forgot password (placeholder) -->
    <div class="flex items-center justify-between border-t pt-4">
        <button type="button"
                class="text-red-500 hover:underline text-sm">Cancel
        </button>
        <span class="text-sm text-white">Forgot <a href="#"
                                                   class="text-blue-600 hover:underline">password?</a></span>
    </div>

</form>

</body>
</html>
