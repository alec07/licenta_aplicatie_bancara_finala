<?php
require('include/db.inc.php');
$query = "SELECT * FROM inregistrare_client  WHERE user_type = 'user'";
$result = mysqli_query($conn, $query);
$total_utilizatori = mysqli_num_rows($result);
$query="SELECT * FROM produse_bancare";
$result = mysqli_query($conn, $query);
$total_produse = mysqli_num_rows($result);

?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>
<div class="p-4 sm:ml-64">
    <div class="flex">
        <div class=" w-1/3 mb-5 ">
            <a href="utilizatori.php"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mr-2 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total utilizatori
                </h5>
                <div class="flex items-center ">
                    <p class="text-2xl font-normal text-gray-700 mr-2 "><?php echo $total_utilizatori; ?></p>
                    <p class="font-normal text-green-700 ">
                        <?php
                            // Data curentă
                            $current_month = date('m');

                            // Luna precedentă
                            $last_month = date('m', strtotime('-1 month'));

                            // Interogarea pentru numărul de utilizatori înregistrați în luna precedentă
                            $sql_last_month = "SELECT COUNT(*) AS num_users FROM inregistrare_client WHERE MONTH(data_deschidere) = '$last_month'";
                            $result_last_month = mysqli_query($conn, $sql_last_month);
                            $row_last_month = mysqli_fetch_assoc($result_last_month);
                            $num_users_last_month = $row_last_month['num_users'];

                            // Interogarea pentru numărul de utilizatori înregistrați în luna curentă
                            $sql_current_month = "SELECT COUNT(*) AS num_users FROM inregistrare_client WHERE MONTH(data_deschidere) = '$current_month'";
                            $result_current_month = mysqli_query($conn, $sql_current_month);
                            $row_current_month = mysqli_fetch_assoc($result_current_month);
                            $num_users_current_month = $row_current_month['num_users'];

                            // Verificare daca numarul de utilizatori din luna anterioara este diferit de 0
                            if ($num_users_last_month > 0) {
                            // Calculare crestere procentuala
                            $growth_rate = (($num_users_current_month  - $num_users_last_month) / $num_users_last_month) * 100;
                            } else {
                            // Setare crestere procentuala la 0 daca numarul de utilizatori din luna anterioara este 0
                            $growth_rate = 0;
                            }
                            echo "+ $growth_rate% de luna trecuta.";
                        ?>
                    </p>
                </div>
            </a>

        </div>
        <div class="w-1/3 mb-5 ">
            <a href="produse.php"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total produse bancare
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo $total_produse; ?></p>
            </a>
        </div>
        <div class="w-1/3 mb-5 ">
            <a href="tranzactii.php"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total transferuri bancare
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    <?php
                     $query = "SELECT SUM(suma_transfer) AS suma_totala FROM transferuri";
                    // Execută query-ul
                    $result = mysqli_query($conn, $query);

                    // Verifică dacă query-ul a avut succes
                    if ($result) {
                        // Extrage rândul rezultat
                        $row = mysqli_fetch_assoc($result);

                        // Afișează suma totală a banilor
                        echo  $row["suma_totala"]." "."RON";
                    } else {
                        echo "Eroare la executarea query-ului: " . mysqli_error($conn);
                    } ?>
                    </p>
            </a>
        </div>
    </div>
    <div class="flex">
        <div class="w-1/2 mb-5 mt-10">
            <h1 class="text-center mb-10">Numar de inregistrari in aplicatie</h1>
            <canvas id="registrationsChart"></canvas>
            <?php
            include('include/db.inc.php');

            // Interogare baza de date pentru a extrage numarul de inregistrari pentru fiecare zi din ultima luna
            $sql = "SELECT DATE(data_deschidere) AS data, COUNT(*) AS numar_inregistrari FROM inregistrare_client WHERE data_deschidere >= DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE(data_deschidere)";
            $result = $conn->query($sql);

            // Procesare date pentru grafic
            $labels = [];
            $data = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $labels[] = $row["data"];
                    $data[] = $row["numar_inregistrari"];
                }
            }
            ?>
        </div>
        <div class="w-1/2 mb-5 mt-10">
            <h1 class="text-center mb-10">Numar de tranzactii in aplicatie</h1>


        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Definirea datelor pentru grafic
var ctx = document.getElementById("registrationsChart").getContext("2d");
var myChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: "Numar de inregistrari",
            data: <?php echo json_encode($data); ?>,
            fill: false,
            borderColor: "rgb(167, 139, 250)",
            lineTension: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{

                beginAtZero: true,
                ticks: {
                    stepSize: 5,
                    precision: 0
                }
            }]
        }
    }
});
</script>


<?php require('partials/footer.php') ?>