<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">


        <body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Deschidere card</h1>

        <form class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="nume" class="block text-gray-700 font-semibold">Nume:</label>
                <input type="text" id="nume" name="nume" class="border border-gray-300 rounded-md px-4 py-2 w-full"
                    required>
            </div>

            <div class="mb-4">
                <label for="prenume" class="block text-gray-700 font-semibold">Prenume:</label>
                <input type="text" id="prenume" name="prenume" class="border border-gray-300 rounded-md px-4 py-2 w-full"
                    required>
            </div>

            <div class="mb-4">
                <label for="numar_card" class="block text-gray-700 font-semibold">Număr card:</label>
                <input type="text" id="numar_card" name="numar_card"
                    class="border border-gray-300 rounded-md px-4 py-2 w-full" required>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Deschide
                    card</button>
            </div>
        </form>
    </div>
</body>

        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>