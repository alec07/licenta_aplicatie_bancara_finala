<?php
include('includes/db.inc.php');
session_start();
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<?php require('partials/sidebar.php')?>
<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="
          w-full
          max-w-6xl
          min-h-screen
          mx-auto
          bg-white
          dark:bg-muted-900">


            <div class="flex justify-between py-4 ">
                <div class=" mb-3 xl:w-96">
                    <div class=" relative mb-4 flex w-full flex-wrap items-stretch">
                        <input type="search"
                            class="relative m-0 block w-[1%] min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                            placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />
                    </div>
                </div>
                <div class="justify-self-end ">

                </div>
            </div>

            <!-- primul rand -->
            <div class="grid grid-cols-3 ">
                <!-- prima coloana -->
                <div class="rounded-lg outline outline-2  outline-offset-2 col-span-1 mr-10">
                    <div class="p-10">
                        <div class="h-full flex flex-col justify-between gap-5">
                            <h4 class=" font-heading font-semibold text-xs uppercase  text-slate-400 opacity-100 ">
                                <?php
                                    if (isset($_SESSION['email'])) {
                                        $email = $_SESSION['email'];
                                        $query = "SELECT prenume FROM inregistrare_client WHERE email='$email'";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            $user_data = mysqli_fetch_assoc($result);
                                            echo " ". $user_data['prenume'] . "'s account";
                                        } else {
                                            echo 'Nu s-au găsit date pentru utilizatorul curent';
                                        }
                                    } else {
                                        echo 'Nu există o sesiune validă pentru utilizatorul curent';
                                    }
                                    ?>
                            </h4>
                            <h2 class="  font-heading font-medium text-4xl ptablet:text-2xl  dark:text-white">
                                <?php
                                    if (isset($_SESSION['email'])) {
                                        $email = $_SESSION['email'];
                                        $query = "SELECT nume FROM inregistrare_client WHERE email='$email'";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            $user_data = mysqli_fetch_assoc($result);
                                            echo 'Bun venit, ' . $user_data['nume'] . '!';
                                        } else {
                                            echo 'Nu s-au găsit date pentru utilizatorul curent';
                                        }
                                    } else {
                                        echo 'Nu există o sesiune validă pentru utilizatorul curent';
                                    }
                                    ?>


                            </h2>

                            <p class="text-justify font-normal text-slate-500 ">Totul pare să fie în regulă și la zi cu
                                contul dvs. de la ultima
                                dvs. vizită.
                                Doriți să faceti vreun transfer?</p>
                            <button class="rounded-full bg-violet-500 p-2 text-white "> <a
                                    href="transferuri.php">Transfera</a></button>
                        </div>
                    </div>
                </div>
                <!-- a doua coloana -->
                <div class="rounded-lg outline outline-2  outline-offset-2 col-span-2">
                    <div class="bg-white">
                        <div class="flex flex-col gap-4 px-8 pt-8 text-center items-center justify-center ">
                            <h4 class=" font-heading font-semibold text-sm uppercase  text-slate-400 opacity-100 ">
                                Soldul contului</h4>
                            <p class="flex">
                                <span class="text-3xl bold">
                                    <?php

                                        if (isset($_SESSION['id_client'])) {
                                            $id_client = $_SESSION['id_client'];
                                            $query = "SELECT suma_depusa FROM conturi WHERE id_client='$id_client'";
                                            $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            $result = mysqli_fetch_assoc($result);
                                            echo $result['suma_depusa'];
                                        }
                                        }
                                    ?>
                                </span>
                                <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                    <path d="M12 3v3m0 12v3" />
                                </svg>
                            </p>
                            <canvas width="50" height="20" id="myChart"></canvas>
                            <!-- <?php
                            if (isset($_SESSION['id_client'])) {// Get the client ID from the session
                                $id_client = $_SESSION['id_client'];
                                // Build the query

                                    // Build the query

                                    // Build the query
                                    $query = "SELECT DATE(t.data_transfer) AS date, SUM(t.suma_transfer) AS total
                                    FROM transferuri t
                                    INNER JOIN conturi c ON t.id_client_sursa = c.id_cont
                                    WHERE c.id_client = $id_client
                                    GROUP BY DATE(t.data_transfer)";
                                    $result = $conn->query($query);

                                    // Store the data in an array
                                    $data = array();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        $data[$row['date']] = $row['total'];
                                        }
                                    }
                                }

                                ?> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- al doilea rand -->
            <div class=" grid grid-cols-2 mt-10 col-span-12 md:col-span-6">
                <!-- prima coloana -->
                <div class=" p-10 h-full bg-white rounded-xl border mr-10">
                    <div class=" h-full flex flex-col justify-between gap-7">
                        <h4
                            class="font-heading font-semibold text-sm uppercase text-muted-400 text-slate-400 opacity-100">
                            Bani transferati in ultimele 30 de zile</h4>
                        <p class="flex">
                            <span class="text-6xl bold">
                                <?php
                                    // Preluăm ID-ul clientului conectat în sesiune
                                    $id_client = $_SESSION['id_client'];
                                    // Calculăm data de acum 30 de zile
                                    $date = date('Y-m-d', strtotime('-30 days'));
                                    $query = "SELECT SUM(suma_transfer) AS total_suma FROM transferuri WHERE id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') AND data_transfer >= '$date'";
                                    // Executăm interogarea și obținem rezultatul
                                    $result = mysqli_query($conn, $query);
                                    // Obținem suma totală transferată în ultimele 30 de zile
                                    $row = mysqli_fetch_assoc($result);
                                    $total_sum = $row['total_suma'];
                                    // Verificăm dacă există transferuri în ultimele 30 de zile
                                    if ($total_sum !== null) {
                                        // Afisam suma totala transferata in ultimele 30 de zile
                                        echo " " . $total_sum;
                                    } else {
                                        echo "0.00";
                                    }
                                ?>
                            </span>
                            <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                <path d="M12 3v3m0 12v3" />
                            </svg>
                        </p>
                        <div class="mt-2 text-right">
                            <a href="toate-transferurile.php"
                                class="text-violet-500 group inline-flex items-center gap-3 text-primary-500 hover:text-primary-400 transition-colors duration-300">

                                <span class=" font-sans font-medium text-base">Vezi toate</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- a doua coloana -->
                <div class="p-10 h-full bg-white rounded-xl border ">
                    <div class=" h-full flex flex-col justify-between gap-7">
                        <h4
                            class="font-heading font-semibold text-sm uppercase text-muted-400 text-slate-400 opacity-100">
                            Bani primiti in ultimele 30 de zile</h4>
                        <p class="flex">
                            <span class="text-6xl bold">
                                <?php
                                    // Preluăm ID-ul clientului conectat în sesiune
                                    $id_client = $_SESSION['id_client'];

                                    // Calculăm data de acum 30 de zile în formatul de date al MySQL
                                    $date_limit = date('Y-m-d', strtotime('-30 days'));

                                    // Executăm interogarea
                                    $query = "SELECT SUM(suma_transfer) as total_sum FROM transferuri WHERE id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') AND data_transfer >= '$date_limit'";

                                    $result = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    $total_sum = $row['total_sum'];
                                    // Verificăm dacă interogarea a avut succes
                                    if ($total_sum !== null) {
                                        // Afisam suma totala primita in ultimele 30 de zile
                                        echo " " . $total_sum;
                                    } else {
                                        // Dacă interogarea a eșuat, afișăm un mesaj de eroare
                                        echo "0.00 ";
                                    }


                                    ?>
                            </span>
                            <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                <path d="M12 3v3m0 12v3" />
                            </svg>
                        </p>
                        <div class="mt-2 text-right">
                            <a href="toate-transferurile.php"
                                class="text-violet-500 group inline-flex items-center gap-3 text-primary-500 hover:text-primary-400 transition-colors duration-300">

                                <span class=" font-sans font-medium text-base">Vezi toate</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- al treilea rand -->
            <div class=" grid grid-cols-1 mt-10 col-span-12 md:col-span-6">
                <div class=" p-10 h-full bg-white rounded-xl border ">
                    <div class=" text-justify flex  items-center place-content-center justify-between">
                        <h4
                            class="font-heading font-semibold text-sm uppercase text-muted-400 text-slate-400 opacity-100">
                            Tranzactii recente</h4>
                        <div class="mt-2 text-right">
                            <a href="toate-transferurile.php"
                                class="text-violet-500 group inline-flex items-center gap-3 text-primary-500 hover:text-primary-400 transition-colors duration-300">

                                <span class=" font-sans font-medium text-base">Vezi toate</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>


                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-center text-gray-500 ">
                            <thead>
                                <tr>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Id</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Nume Destinatar</th>
                                    <th class="text-slate-500 text-sm font-medium px-2 py-2">Suma Transferata</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Data si Ora</th>

                                    <!-- adaugam o coloana pentru butoanele de actiune -->
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php
                                        // Preluarea ID-ului clientului conectat în sesiune
                                        $id_client = $_SESSION['id_client'];

                                        // Interogarea bazei de date pentru a obține informații despre transferurile efectuate de clientul conectat în sesiune
                                        $query = "SELECT transferuri.id_transfer, transferuri.id_client_destinatie, transferuri.suma_transfer, transferuri.data_transfer,transferuri.nume_beneficiar from transferuri
                                                WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') AND transferuri.data_transfer >= DATE_SUB(NOW(), INTERVAL 10 DAY)";

                                        $result = mysqli_query($conn, $query);

                                        // Verificăm dacă interogarea a întors rezultate
                                        if (mysqli_num_rows($result) > 0) {
                                            // Începem să construim tabelul


                                            // Parcurgem fiecare rând din rezultat și afișăm informațiile în tabel
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td class='px-6 py-2'>" . $row["id_transfer"] . "</td>";
                                                echo "<td class='px-6 py-2'>" . $row["nume_beneficiar"] . "</td>";
                                                echo "<td class='px-6 py-2'>" . $row["suma_transfer"] . "</td>";
                                                echo "<td class='px-6 py-2'>" . $row["data_transfer"] . "</td>";
                                                echo "</tr>";
                                            }

                                            // Închidem tabelul

                                        } else {
                                            // Dacă interogarea nu a întors rezultate, afișăm un mesaj corespunzător
                                            echo "Nu s-au găsit transferuri în ultimele 30 de zile.";
                                        }

                                        // Închidem conexiunea la baza de date
                                        mysqli_close($conn);
                                        ?>

                            </tbody>
                        </table>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($data)); ?>,
            datasets: [{
                label: 'Money transferred per day',
                data: <?php echo json_encode(array_values($data)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: "rgb(167, 139, 250)",
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
    <?php require('partials/footer.php'); ?>