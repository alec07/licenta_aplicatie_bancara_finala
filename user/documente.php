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
            <section>
                <h2 class="text-lg font-semibold mb-2">Lista documentelor</h2>

                <ul class="space-y-2">
                    <li>
                        <a class="text-blue-500" href="../documente/Operatiuni curente.pdf" download>Operatiuni
                            Curente</a> <br>
                        <p class="text-gray-500">Data:
                            <?php
                                $query = "SELECT MIN(data_depunere) AS data_primului_depozit FROM depozite WHERE id_client = {$_SESSION['id_client']}";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['data_primului_depozit'];
                                }
                            ?>
                        </p>
                    </li>
                    <!-- se va afisa numai daca exista un depozit deschis -->
                    <?php
                        $query = "SELECT MIN(data_depunere) AS data_primului_depozit FROM depozite WHERE id_client = {$_SESSION['id_client']}";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $data_primului_depozit = $row['data_primului_depozit'];

                            if ($data_primului_depozit !== null) {
                        ?>

                    <li>
                        <a class="text-blue-500" href="../documente/depozie_contract.pdf" download>Termeni și condiții depozite</a>
                        <br>
                        <p class="text-gray-500">Data: <?php echo $data_primului_depozit; ?></p>
                    </li>

                    <?php
                        }
                    }
                    ?>


                    <li>
                        <a class="text-blue-500" href="../documente/contractbanca.pdf" download>Contract banca</a>
                        <p class="text-gray-500">Data:
                            <?php
                            $query = "SELECT data_deschidere FROM inregistrare_client WHERE id_client = {$_SESSION['id_client']}";
                            $result = mysqli_query($conn, $query);

                            $query = "SELECT DATE_FORMAT(data_deschidere, '%Y-%m-%d') AS data FROM inregistrare_client WHERE id_client = {$_SESSION['id_client']}";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo $row['data'] . "<br>";
                                }
                            }
                            ?>
                        </p>
                    </li>
                </ul>
            </section>


        </div>
    </div>
</div>



<?php require('partials/footer.php') ?>