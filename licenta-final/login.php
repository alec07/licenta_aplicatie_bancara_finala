

<?php
session_start();

// Verifică dacă există un mesaj de eroare în sesiune
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']); // Șterge mesajul de eroare din sesiune
}
?>

<?php include ('partials/header2.php'); ?>
<nav class="bg-black ">
    <div class="max-w-4xl mx-auto">
        <div class="w-full container mx-auto">
            <div class="w-full flex items-center justify-between">
                <div class="mt-10 w-20 h-20 grid grid-cols-2 grid-rows-2 gap-2 mb-5 ">
                    <div class="bg-orange-200 text-white font-bold flex items-center justify-center">C</div>
                    <div class="bg-orange-200 text-white font-bold flex items-center justify-center">E</div>
                    <div class="bg-orange-200 text-white font-bold flex items-center justify-center">L</div>
                    <div class="bg-orange-200 text-white font-bold flex items-center justify-center">O</div>
                    <div class="items-center justify-center text-xs text-orange-200 ">Bank
                    </div>
                </div>
            </div>
        </div>

    </div>
</nav>

<div class="mt-20 max-w-4xl mx-auto">
    <!-- conținutul paginii -->
    <div class="mt-5 mb-5">
        <!-- Afisarea mesajului de eroare, daca exista -->
    <?php if (isset($errorMessage)) : ?>
        <p class= "mb-5" style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
        <h1 class="text-orange-200 font-serif text-4xl mb-10">INTRĂ ÎN CONT</h1>
        <form action="login_process.php" method="post">
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="email" id="email"
                    class="bg-orange-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="name@example.com" required="">
            </div>
            <div>
                <label for="parola"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parola</label>
                <input type="password" name="parola" id="password" placeholder="••••••••"
                    class="bg-orange-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required="">
            </div>
            <button type="submit"
                class=" mt-5 w-full text-white bg-orange-200 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Conectare</button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Nu ai încă un cont deschis la noi? <a href="#"
                    class="font-medium text-primary-600 hover:underline dark:text-primary-500">Contactează-ne</a>
            </p>
        </form>
    </div>
    <div class="text-gray-500">