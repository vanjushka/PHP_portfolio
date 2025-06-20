<?php
declare(strict_types=1);
$pageTitle = 'Contact — Vanja Dunkel';

// Pull in the form‐processing logic
require __DIR__ . '/app/Logic/contact_process.php';

// Render header
require __DIR__ . '/app/Views/partials/header.php';
?>

    <main class="pt-20">
        <!-- Header Section -->
        <section class="bg-primary py-16">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h1 class="text-4xl font-extrabold mb-4">Get in Touch</h1>
                <p class="text-lg text-grayish max-w-xl mx-auto">
                    Whether you have a project idea, a collaboration request, or just want to say hi, feel free to reach
                    out!
                    I’ll get back to you asap.
                </p>
            </div>
        </section>

        <!-- Enquiry Section -->
        <section class="max-w-3xl mx-auto px-4 py-12">

            <?php if ($errormessage): ?>
                <div class="text-red-500 mb-6"><?= htmlspecialchars($errormessage) ?></div>
            <?php endif; ?>
            <?php if ($successmessage): ?>
                <div class="text-green-500 mb-6"><?= htmlspecialchars($successmessage) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6 bg-dark p-6 rounded-lg border border-medium">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="last_name" class="block mb-1 text-grayish">Last Name</label>
                        <input type="text" id="last_name" name="last_name" autocomplete="family-name" required
                               value="<?= htmlspecialchars($last_name) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                    <div>
                        <label for="first_name" class="block mb-1 text-grayish">First Name</label>
                        <input type="text" id="first_name" name="first_name" autocomplete="given-name" required
                               value="<?= htmlspecialchars($first_name) ?>"
                               class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block mb-1 text-grayish">Email</label>
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
                    <label for="plz_ort" class="block mb-1 text-grayish">Street and Postal Code</label>
                    <input type="text" id="plz_ort" name="plz_ort" autocomplete="postal-code"
                           value="<?= htmlspecialchars($plz_ort) ?>"
                           class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"/>
                </div>

                <div>
                    <label for="message" class="block mb-1 text-grayish">Message</label>
                    <textarea id="message" name="message" rows="5" required
                              class="w-full px-4 py-2 bg-white text-black border border-medium rounded focus:outline-none focus:ring-2 focus:ring-accent"><?= htmlspecialchars($message) ?></textarea>
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                            class="flex-1 bg-accent text-primary font-semibold py-2 rounded hover:bg-orange-600 transition">
                        Send
                    </button>
                    <button type="reset"
                            class="flex-1 bg-medium text-white font-semibold py-2 rounded hover:bg-dark transition">
                        Reset
                    </button>
                </div>
            </form>
        </section>

        <!-- FAQ & Impressum remain unchanged -->

    </main>

<?php
require __DIR__ . '/app/Views/partials/footer.php';
