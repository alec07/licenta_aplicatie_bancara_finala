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
            <h1 class="text-3xl text-center"> Procesare depozite deschise</h1>
            <p class="font-thin text-center" >*depozitul poate fi retras numai dupa ce a trecut perioada de expirare</p>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="mt-10 overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>

                                        <th scope="col" class="px-6 py-4">Nume depozit</th>
                                        <th scope="col" class="px-6 py-4">Suma depozit</th>
                                        <th scope="col" class="px-6 py-4">Data depunerii</th>
                                        <th scope="col" class="px-6 py-4">Data expirării</th>
                                        <th scope="col" class="px-6 py-4">Perioada(luni)</th>
                                        <th scope="col" class="px-6 py-4">Actiuni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                           $id_client = $_SESSION['id_client']; // ID-ul clientului conectat în sesiune
                                           $query = "SELECT * FROM depozite WHERE id_client = $id_client AND expirat = 0";
                                           $result = mysqli_query($conn, $query);
                                           if (mysqli_num_rows($result) > 0) {
                                               // trecem prin rezultate, și afișăm informațiile despre fiecare depozit
                                               while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr class='border-b dark:border-neutral-500'>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $row['nume_depozit'] . "</td>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['suma_depusa']. "</td>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['data_depunere']. "</td>" ;
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['data_expirare']. "</td>" ;
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['perioada_depozit']. "</td>" ;
                                                    echo "<td>";
                                                    $currentDate = date("Y-m-d");
                                                    $expirareDate = $row['data_expirare'];

                                                    if ($currentDate > $expirareDate) {
                                                        // Perioada de expirare a trecut, putem afișa butonul de retragere
                                                        echo '<form method="POST" action="includes/procesare_expirare_depozit.php">';
                                                        echo '<input type="hidden" name="id_depozit" value="' . $row['id_depozit'] . '">';
                                                        echo '<button type="submit" name="expira_depozit">retrage</button>';
                                                        echo '</form>';
                                                    } else {
                                                        // Perioada de expirare nu a trecut, nu afișăm butonul de retragere
                                                        echo 'Perioada de expirare nu a trecut.';
                                                    }

                                                echo "</tr>";
                                               }
                                           } else {
                                               echo "Nu există depozite deschise pentru acest client.";
                                           }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-20">
                <h1 class="text-3xl text-center"> Depozite inchise</h1>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="mt-10 overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr>

                                            <th scope="col" class="px-6 py-4">Nume depozit</th>
                                            <th scope="col" class="px-6 py-4">Suma depozit</th>
                                            <th scope="col" class="px-6 py-4">Data expirării</th>
                                            <th scope="col" class="px-6 py-4">Data depunerii</th>
                                            <th scope="col" class="px-6 py-4">Perioada(luni)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           $id_client = $_SESSION['id_client']; // ID-ul clientului conectat în sesiune
                                           $query = "SELECT * FROM depozite WHERE id_client = $id_client AND expirat = 1";
                                           $result = mysqli_query($conn, $query);
                                           if (mysqli_num_rows($result) > 0) {
                                               // Iterați prin rezultate și afișați informațiile despre fiecare depozit
                                               while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr class='border-b dark:border-neutral-500'>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $row['nume_depozit'] . "</td>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['suma_depusa']. "</td>";
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['data_expirare']. "</td>" ;
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['data_depunere']. "</td>" ;
                                                   echo "<td class='whitespace-nowrap px-6 py-4'>" .$row['perioada_depozit']. "</td>" ;
                                                echo "</tr>";
                                               }
                                           } else {
                                               echo "Nu există depozite închise pentru acest client.";
                                           }

                                           mysqli_close($conn);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require('partials/footer.php') ?>