<?php
include('includes/db.inc.php');
session_start();
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<?php
// Verificăm dacă există un mesaj de afișat
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<p>".$msg."</p>";
}
?>
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

                <div class="mt-10">
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
                                echo "Nume: <input readonly type='text' name='nume' value='" . $row['nume'] . "'><br>";
                                echo "Iban: <input readonly type='text' name='iban' value='" . $row['iban'] . "'><br>";
                                echo "Suma: <input type='text' name='suma_plata'><br>";
                                echo "Cod Client: <input type='text' name='cod_client'><br>";
                                echo "<input type='submit' value='Salveaza'>";
                                echo "</form>";
                            } else {
                                // Afisare lista cu numele
                                echo "<form method='post' action=''>";
                                echo "<select class='border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]'  name='nume'>";
                                echo "<option   value=''>-- Selecteaza un nume --</option>";
                                echo $options;
                                echo "</select>";
                                echo "<input type='submit' value='Afiseaza'>";
                                echo "</form>";
                            }

                            // Inchidere conexiune
                            mysqli_close($conn);
                        ?>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M11 5a3 3 0 11-6 0 3 3 0 016 0zM2.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-5.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2h-2a.75.75 0 000 1.5h2v2a.75.75 0 001.5 0v-2h2a.75.75 0 000-1.5h-2v-2z" />
                    </svg>

                </div>
                <a href=""><button class="mt-10 px-8 py-2 rounded-lg bg-violet-500 text-white"
                        type="">Plateste</button></a>

            </div>
        </div>

    </div>





    <?php require('partials/footer.php') ?>