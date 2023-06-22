<?php
include('includes/db.inc.php');
session_start();
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">

    <!-- nav -->
    <div class=" absolute top-0 left-0 w-full">
        <div class="w-full max-w-6xl mx-auto px-4">
            <div class="w-full flex items-center justify-between py-5">
                <div class="flex-1 flex items-center">
                    <a href="dashboard.user.php">CeloBank</a>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-end">
                        <a href="dashboard.user.php"><button type="">x</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class=" w-full pt-20  align-center justify-center">
        <div class="w-full max-w-6xl mx-auto ">
            <div class="text-center  ">
                <h2 class="text-4xl">Plata factura</h2>
                <p class="mt-2 flex align-center justify-center">
                    <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <span class="">Dupa o plata catre un facturier nou, salveaza-l ca favorit pentru a plati mai usor pe
                        viitor.</span>
                </p>

                <div class="mt-10 text-center">
                    <?php
                            // Cautare nume din baza de date
                            $sql = "SELECT nume FROM facturieri";
                            $result = $conn->query($sql);

                            // Creare lista cu nume
                            $lista_nume = array();
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $lista_nume[] = $row["nume"];
                                }
                            }
                            // Interogare pentru a selecta numele din baza de date
                            $sql = "SELECT nume FROM facturieri";
                            $result = mysqli_query($conn, $sql);

                            // Creare lista cu numele
                            $options = "";
                            while ($row = mysqli_fetch_array($result)) {
                                $options .= "<option value='" . $row['nume'] . "'>" . $row['nume'] . "</option>";
                            }

                            // Afisare formular cu date precompletate in functie de numele selectat
                            if (isset($_POST['nume'])) {
                                $sql = "SELECT * FROM facturieri WHERE nume = '" . $_POST['nume'] . "'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);

                                // Afisare formular cu date precompletate
                                echo "<form method='post' action='includes/get_facturieri.php'>";
                                echo "<p class='mb-2 text-lg mr-5 text-gray-500 font-bold inline-block'>Nume: </p><input readonly class='mb-2 text-lg mr-5 ' type='text' name='nume' value='" . $row['nume'] . "'><br>";
                                echo "<p class='mb-2 text-lg mr-5 text-gray-500 font-bold inline-block'>Iban: </p><input readonly class='mb-2 text-lg mr-5 ' type='text' name='iban' value='" . $row['iban'] . "'><br>";
                                echo "<p class='mb-2 text-lg mr-5 text-gray-500 font-bold inline-block'>Suma: </p><input class='mb-2 text-lg mr-5 ' type='text' name='suma_plata'><br>";
                                echo "<p class='mb-2 text-lg mr-5 text-gray-500 font-bold inline-block'>Cod Client: </p><input class='mb-2 text-lg mr-5 ' type='text' name='cod_client'><br>";
                                echo "<input type='submit' class='mt-10 px-8 py-2 rounded-lg bg-violet-500 text-white' value='Salveaza'>";
                                echo "</form>";
                            } else {
                                // Afisare lista cu numele
                                echo "<form method='post' action=''>";
                                echo "<select class='border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]'  name='nume'>";
                                echo "<option   value=''>-- Selecteaza un nume --</option>";
                                echo $options;
                                echo "</select>";
                                echo " <a href=''><button type='submit' value='Afiseaza' class='mt-10 px-8 py-2 rounded-lg bg-violet-500 text-white'
                                >Afiseaza</button></a> ";
                                echo "</form>";
                            }

                            // Inchidere conexiune
                            mysqli_close($conn);
                        ?>


                </div>


            </div>
        </div>

    </div>





    <?php require('partials/footer.php') ?>