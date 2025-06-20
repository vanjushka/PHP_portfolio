<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black flex items-center justify-center min-h-screen">

<form action="" method="post"
      class="bg-black border-2 border-white rounded-lg p-8 w-full max-w-md space-y-6">

    <!-- Show validation errors -->
    <?php if (!empty($errormessage)): ?>
        <div class="text-red-500 mb-4">
            <?= htmlspecialchars($errormessage) ?>
        </div>
    <?php endif; ?>

    <!-- Show success with unescaped link -->
    <?php if (!empty($successmessage)): ?>
        <div class="text-green-500 mb-4">
            <?= $successmessage ?>
        </div>
    <?php endif; ?>

    <h2 class="text-white text-2xl font-bold mb-4 text-center">Register</h2>

    <div>
        <label for="username" class="block text-white font-semibold mb-1">Username</label>
        <input
                type="text"
                name="username"
                id="username"
                required
                value="<?= htmlspecialchars($username ?? '') ?>"
                class="w-full px-4 py-2 bg-white text-black border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <div>
        <label for="email" class="block text-white font-semibold mb-1">Email</label>
        <input
                type="email"
                name="email"
                id="email"
                required
                value="<?= htmlspecialchars($email ?? '') ?>"
                class="w-full px-4 py-2 bg-white text-black border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <div>
        <label for="password" class="block text-white font-semibold mb-1">Password</label>
        <input
                type="password"
                name="password"
                id="password"
                required
                class="w-full px-4 py-2 bg-white text-black border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <div>
        <label for="password_repeat" class="block text-white font-semibold mb-1">Repeat Password</label>
        <input
                type="password"
                name="password_repeat"
                id="password_repeat"
                required
                class="w-full px-4 py-2 bg-white text-black border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <button
            type="submit"
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition"
    >
        Register
    </button>

    <p class="text-white text-sm text-center pt-4">
        Already have an account?
        <a href="login.php" class="text-blue-400 underline hover:text-blue-300">Login here</a>
    </p>
</form>

</body>
</html>
