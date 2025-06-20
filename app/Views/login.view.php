<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black flex items-center justify-center min-h-screen">

<form action="dashboard.php" method="post"
      class="bg-black border-2 border-white rounded-lg p-8 w-full max-w-md space-y-6">

    <!-- Error Message -->
    <?php if (!empty($errormessage)): ?>
        <div class="text-red-500"><?= htmlspecialchars($errormessage) ?></div>
    <?php endif; ?>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-white font-semibold mb-2">Email</label>
        <input
                id="email" name="email" type="email" required
                placeholder="you@example.com"
                value="<?= htmlspecialchars($email ?? '') ?>"
                class="w-full px-4 py-2 bg-white text-black placeholder-gray-500 border border-gray-400 rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-white font-semibold mb-2">Password</label>
        <input
                id="password" name="password" type="password" required
                placeholder="••••••••"
                class="w-full px-4 py-2 bg-white text-black placeholder-gray-500 border border-gray-400 rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
    </div>

    <!-- Remember & Submit -->
    <div class="flex items-center justify-between">
        <label class="flex items-center text-white">
            <input type="checkbox" name="remember"
                   class="mr-2 h-4 w-4 text-accent bg-white border-gray-400 rounded focus:ring-accent"/>
            Remember me
        </label>
        <button
                type="submit"
                class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition"
        >
            Login
        </button>

    </div>

    <!-- Footer Links -->
    <div class="flex justify-between border-t border-gray-700 pt-4">
        <a href="register.php"
           class="text-sm text-white hover:underline">
            New here? Please register
        </a>
        <a href="#"
           class="text-sm text-white hover:underline">
            Forgot password?
        </a>
    </div>

</form>

</body>
</html>
