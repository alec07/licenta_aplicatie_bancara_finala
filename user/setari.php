<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<?php require('partials/sidebar.php') ?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700">
    <div class="p-4 sm:ml-64">
    <?php
//Verificăm dacă există un mesaj de afișat
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<p>".$msg."</p>";
}
?>
        <form method="POST" action="includes/schimbare_parola.inc.php" class="mb-4">
            <label for="parolaVeche" class="mr-2">Parola veche:</label>
            <input type="password" id="parolaVeche" name="parolaVeche" class="border border-gray-300 rounded px-3 py-2">

            <label for="parolaNoua" class="mr-2">Parola nouă:</label>
            <input type="password" id="parolaNoua" name="parolaNoua" class="border border-gray-300 rounded px-3 py-2">

            <label for="confirmareParola" class="mr-2">Confirmă parola nouă:</label>
            <input type="password" id="confirmareParola" name="confirmareParola"
                class="border border-gray-300 rounded px-3 py-2">

            <button type="submit" name="schimbaParola"
                class="font-sans font-medium text-sm inline-flex items-center justify-center hover:bg-violet-200 gap-2 h-9 px-6 rounded-full bg-violet-100 text-violet-500 hover:text-violet-600 transition-all duration-300 tw-accessibility">
                <svg class="h-4 w-4 text-violet-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                </svg>
                Schimbă parola
            </button>
        </form>

    </div>
</div>

<?php require('partials/footer.php') ?>