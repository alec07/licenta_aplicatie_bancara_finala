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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total transferuri
                    bancare
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

        <div class="w-1/2 mb-5 mt-10">
            <h1 class="text-center mb-10">Numar de înregistrări în aplicație</h1>
            <canvas id="registrationsChart"></canvas>
        </div>


        <script>
        // Functie pentru a face solicitarea AJAX catre server pentru a obtine datele actualizate
        function fetchData() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        updateChart(response.labels, response.data);
                    }
                }
            };
            xhr.open("GET", "fetch_data.php", true);
            xhr.send();
        }

        // Functie pentru a actualiza graficul cu datele primite
        function updateChart(labels, data) {
            var ctx = document.getElementById("registrationsChart").getContext("2d");
            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Numar de inregistrari",
                        data: data,
                        fill: false,
                        borderColor: "rgb(167, 139, 250)",
                        lineTension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Apel initial pentru a afisa graficul cu datele initiale
        updateChart(<?php echo json_encode($labels); ?>, <?php echo json_encode($data); ?>);

        // Actualizare periodica a datelor
        setInterval(fetchData, 5000); // Actualizeaza datele la fiecare 5 secunde
        </script>

        <div class="w-1/2  mt-10">
            <h1 class="text-center mb-10">Soldurile medii ale clienților după tranzacții</h1>
            <?php
                include('include/db.inc.php');
                // Interogare SQL pentru a obține soldurile medii pe conturi în DE TRANSFERURI
                $sql = "SELECT c.id_cont, AVG(t.suma_transfer) AS sold_mediu, t.data_transfer
                        FROM conturi c
                        JOIN transferuri t ON c.id_cont = t.id_client_sursa
                        GROUP BY c.id_cont, DATE_FORMAT(t.data_transfer, 'perioada_dorita')";
                $result = mysqli_query($conn, $sql);
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = array(
                        'id_cont' => $row['id_cont'],
                        'sold_mediu' => $row['sold_mediu'],
                        'data_transfer' => $row['data_transfer']
                    );
                }

                // Închideți conexiunea la baza de date
                mysqli_close($conn);
            ?>
            <canvas id="grafic"></canvas>
        </div>
        <script>
        // Definirea datelor pentru graficul de depozite
        var ctxsolduriMedii = document.getElementById('grafic').getContext('2d');
        var solduriMediiData = <?php echo json_encode($data); ?>;
        var solduriMediiLabels = solduriMediiData.map(function(item) {
            return item.data_transfer;
        });
        var solduriMedii = solduriMediiData.map(function(item) {
            return item.sold_mediu;
        });
        var solduriMediiChartData = {
            labels: solduriMediiLabels,
            datasets: [{
                label: 'Solduri medii',
                data: solduriMedii,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        var solduriMediiChartOptions = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
        var solduriMediiChart = new Chart(ctxsolduriMedii, {
            type: 'line',
            data: solduriMediiChartData,
            options: solduriMediiChartOptions
        });
        </script>
    </div>
</div>

<?php require('partials/footer.php') ?>