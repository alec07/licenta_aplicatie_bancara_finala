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
            <h1 class="text-3xl text-center"> Documente </h1>
            <p class="font-thin text-center">vizualizeaza si descarca-ti documentele</p>
            <a href="../documente/Operatiuni curente.pdf" download>Operatiuni Curente</a> <br>
            <a href="../documente/contractbanca.pdf" download>Contract banca</a>
        </div>
    </div>
</div>



<?php require('partials/footer.php') ?>