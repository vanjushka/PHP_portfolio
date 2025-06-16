<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen">

<form action="" method="post" class="bg-black shadow-lg rounded-lg p-8 w-full max-w-md space-y-6">

    <?php if (!empty($errormessage)): ?>
        <div class="text-red-500 mb-4"><?php echo htmlspecialchars($errormessage); ?></div>
    <?php endif; ?>

    <?php if (!empty($successmessage)): ?>
        <div class="text-green-500 mb-4"><?php echo $successmessage; ?></div>
    <?php endif; ?>

    <h2 class="text-white text-2xl font-bold mb-4 text-center">Register</h2>

    <div>
        <label class="block text-white mb-1" for="username">Username</label>
        <input type="text" name="username" required class="w-full p-2 rounded border focus:outline-none focus:ring-2">
    </div>

    <div>
        <label class="block text-white mb-1" for="email">Email</label>
        <input type="email" name="email" required class="w-full p-2 rounded border focus:outline-none focus:ring-2">
    </div>

    <div>
        <label class="block text-white mb-1" for="password">Password</label>
        <input type="password" name="password" required
               class="w-full p-2 rounded border focus:outline-none focus:ring-2">
    </div>

    <div>
        <label class="block text-white mb-1" for="password_repeat">Repeat Password</label>
        <input type="password" name="password_repeat" required
               class="w-full p-2 rounded border focus:outline-none focus:ring-2">
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
        Register
    </button>

    <p class="text-white text-sm text-center pt-4">
        Already have an account? <a href="login.php" class="text-blue-400 underline">Login here</a>
    </p>

</form>

</body>
</html>
