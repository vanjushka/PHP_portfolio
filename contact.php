<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

$pageTitle = 'Contact — Vanja Dunkel';

$last_name = '';
$first_name = '';
$email = '';
$address = '';
$plz_ort = '';
$message = '';
$errormessage = '';
$successmessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_name = trim($_POST['last_name'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $plz_ort = trim($_POST['plz_ort'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($last_name) || empty($first_name) || empty($email) || empty($message)) {
        $errormessage = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormessage = 'Please enter a valid email address.';
    } else {
        // Build email
        $to = 'vanja.dunkel@gmail.com';
        $subject = "New enquiry from {$first_name} {$last_name}";
        $body = "Name: {$first_name} {$last_name}\n"
            . "Email: {$email}\n";
        if ($address) {
            $body .= "Address: {$address}\n";
        }
        if ($plz_ort) {
            $body .= "Postal/City: {$plz_ort}\n";
        }
        $body .= "\nMessage:\n{$message}\n";

        $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
        $headers .= "Reply-To: {$email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $successmessage = 'Thank you for your message! I will get back to you soon.';
            // clear fields
            $last_name = $first_name = $email = $address = $plz_ort = $message = '';
        } else {
            $errormessage = 'Sorry, there was a problem sending your message. Please try again later.';
        }
    }
}

require __DIR__ . '/app/Views/partials/header.php';
?>

    <main class="pt-20">

        <section class="bg-primary py-16">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h1 class="text-4xl font-extrabold mb-4">Get in Touch</h1>
                <p class="text-lg text-grayish max-w-xl mx-auto">
                    Whether you have a project idea, a collaboration request, or just want to say hi, feel free to reach
                    out! I’ll get back to you asap.
                </p>
            </div>
        </section>

        <!-- Contact Form -->
        <section class="max-w-3xl mx-auto px-4 py-12">
            <?php if ($errormessage): ?>
                <div class="mb-6 p-4 bg-red-800 text-white rounded-lg border border-red-700">
                    <?= htmlspecialchars($errormessage) ?>
                </div>
            <?php endif; ?>
            <?php if ($successmessage): ?>
                <div class="mb-6 p-4 bg-green-800 text-white rounded-lg border border-green-700">
                    <?= htmlspecialchars($successmessage) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST"
                  class="space-y-6 bg-dark p-6 rounded-lg border border-medium">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="last_name" class="block mb-1 text-grayish">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" autocomplete="family-name" required
                               value="<?= htmlspecialchars($last_name) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                    <div>
                        <label for="first_name" class="block mb-1 text-grayish">First Name *</label>
                        <input type="text" id="first_name" name="first_name" autocomplete="given-name" required
                               value="<?= htmlspecialchars($first_name) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block mb-1 text-grayish">Email *</label>
                        <input type="email" id="email" name="email" autocomplete="email" required
                               value="<?= htmlspecialchars($email) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                    <div>
                        <label for="address" class="block mb-1 text-grayish">Address</label>
                        <input type="text" id="address" name="address" autocomplete="street-address"
                               value="<?= htmlspecialchars($address) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                </div>

                <div>
                    <label for="plz_ort" class="block mb-1 text-grayish">Street & Postal Code</label>
                    <input type="text" id="plz_ort" name="plz_ort" autocomplete="postal-code"
                           value="<?= htmlspecialchars($plz_ort) ?>"
                           class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                </div>

                <div>
                    <label for="message" class="block mb-1 text-grayish">Message *</label>
                    <textarea id="message" name="message" rows="5" required
                              class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"><?= htmlspecialchars($message) ?></textarea>
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                            class="flex-1 bg-accent text-black font-semibold py-2 rounded hover:bg-opacity-90 transition">
                        Send
                    </button>
                    <button type="reset"
                            class="flex-1 bg-medium text-white font-semibold py-2 rounded hover:bg-dark transition">
                        Reset
                    </button>
                </div>
            </form>
        </section>
    </main>

<?php
require __DIR__ . '/app/Views/partials/footer.php';
