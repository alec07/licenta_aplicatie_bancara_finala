<?php
include('includes/db.inc.php');
session_start();
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<?php require('partials/sidebar.php')?>


<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <h1>
                Deschidere cont
            </h1>
            <p>Prin acceptarea prezentelor Termene și Condiții solicit CeloBank - Sucursala București deschiderea pe
                numele meu a unu cont curent în moneda selectată și să se proceseze Cererea de emitere a unui card de
                debit. <br>
                Cunosc și sunt de acord cu termenii și condițiile, dobânda, taxele și comisioanele aplicabile
                produsului(contului) solicitat prevăzute în Condițiile Generale de Afaceri - Persoane Fizice, Ghidul
                pentru efectuarea Plăților, Lista de dobânzi - Persoane Fizice, Lista de Taxe și Comisioane, Condițiile
                Generale și înțeleg că acestea pot fi modificate în funcție de schimbările legislative și/sau
                modificarea politicii interne a CeloBank, cu respectarea prevederilor contractuale
            </p>
            <input type="checkbox" id="checkbox">
            <label for="checkbox">Accept termenii și condițiile</label>
            <a href="">
                <button class=" bg-violet-300 hover:bg-violet-700 px-3 py-1 rounded-xl text-white m-5" id="submitButton"
                    disabled>Treci mai departe</button>
            </a>
        </div>
    </div>
</div>
<script>
const checkbox = document.getElementById('checkbox');
const submitButton = document.getElementById('submitButton');

checkbox.addEventListener('change', function() {
    submitButton.disabled = !checkbox.checked;
});
</script>


<?php require('partials/footer.php') ?>