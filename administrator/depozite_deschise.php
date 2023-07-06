<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Depozite curente</h2>
                <div class="flex items-center">
                    <span class="mr-2">Perioadă:</span>
                    <form action="" method="GET">
                        <select id="perioada" name="perioada" class="px-2 py-1 border border-gray-400 rounded">
                            <option
                                <?php echo (!isset($_GET['perioada']) || $_GET['perioada'] === 'Toate') ? 'selected' : ''; ?>>
                                Toate</option>
                            <option
                                <?php echo isset($_GET['perioada']) && $_GET['perioada'] === 'Ultima lună' ? 'selected' : ''; ?>>
                                Ultima lună</option>
                            <option
                                <?php echo isset($_GET['perioada']) && $_GET['perioada'] === 'Ultimul trimestru' ? 'selected' : ''; ?>>
                                Ultimul trimestru</option>
                        </select>
                        <button type="submit">Actualizează</button>
                    </form>
                </div>

            </div>
            <div class="mt-8">
                <div id="rezultate-depozite" class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold">Sumar depozite curente</h3>
                    <div class="mt-4">
                        <?php

                            // Verificăm dacă s-a trimis un request GET și dacă există cheia 'perioada' în array-ul $_GET
                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                // Obținem perioada selectată din parametrul GET sau setăm-o implicit la 'Toate'
                                $perioada = isset($_GET['perioada']) ? $_GET['perioada'] : 'Toate';


                                // Inițializăm variabilele pentru numărul și suma totală a depozitelor
                                $numarDepozite = 0;
                                $sumaTotala = 0;

                                // Inițializăm variabila $sql cu o valoare implicită
                                $sql = "";

                                // Verificăm perioada selectată și efectuăm interogarea în funcție de perioada respectivă
                                if ($perioada === 'Toate') {
                                    // Interogare pentru toate depozitele
                                    $sql = "SELECT COUNT(*) AS numarDepozite, SUM(suma_depusa) AS sumaTotala FROM depozite";
                                } elseif ($perioada === 'Ultima lună') {
                                    // Interogare pentru depozitele din ultima lună
                                    $sql = "SELECT COUNT(*) AS numarDepozite, SUM(suma_depusa) AS sumaTotala FROM depozite WHERE data_depunere >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                                } elseif ($perioada === 'Ultimul trimestru') {
                                    // Interogare pentru depozitele din ultimul trimestru
                                    $sql = "SELECT COUNT(*) AS numarDepozite, SUM(suma_depusa) AS sumaTotala FROM depozite WHERE data_depunere >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
                                }

                                // Verificăm dacă $sql are o valoare validă
                                if (!empty($sql)) {
                                    // Executăm interogarea și obținem rezultatele
                                    $result = $conn->query($sql);
                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $numarDepozite = $row['numarDepozite'];
                                        $sumaTotala = $row['sumaTotala'];
                                    }
                                }
                            }


                            ?>
                        <p class="text-gray-600">Număr total de depozite:</p>
                        <p class="text-2xl font-semibold"><?php echo $numarDepozite; ?></p>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">Suma totală a depozitelor:</p>
                        <p id="suma-totala" class="text-2xl font-semibold"> <?php echo $sumaTotala; ?></p>
                    </div>
                </div>
            </div>
            <form method="GET" action="">
                <div class="mt-8">
                    <h3 class="text-lg font-semibold">Filtrare și sortare</h3>
                    <div class="flex mt-4">
                        <div class="mr-4">
                            <label for="filter-amount" class="block mb-2">Filtrare după sumă:</label>
                            <select id="filter-amount" name="filter-amount"
                                class="px-2 py-1 border border-gray-400 rounded">
                                <option value="all">Toate</option>
                                <option value="100">Peste $100</option>
                                <option value="500">Peste $500</option>
                                <option value="1000">Peste $1000</option>
                            </select>
                        </div>
                        <div class="mr-4">
                            <label for="filter-duration" class="block mb-2">Filtrare după durată:</label>
                            <select id="filter-duration" name="filter-duration"
                                class="px-2 py-1 border border-gray-400 rounded">
                                <option value="all">Toate</option>
                                <option value="1">Peste 1 luni</option>
                                <option value="3">Peste 3 luni</option>
                                <option value="6">Peste 6 luni</option>
                                <option value="9">Peste 9 luni</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block mb-2">Sortare:</label>
                            <select id="sort" name="sort" class="px-2 py-1 border border-gray-400 rounded">
                                <option value="numar-asc">Număr depozit (ascendent)</option>
                                <option value="numar-desc">Număr depozit (descendent)</option>
                                <option value="suma-asc">Sumă (ascendent)</option>
                                <option value="suma-desc">Sumă (descendent)</option>
                                <option value="durata-asc">Durată (ascendent)</option>
                                <option value="durata-desc">Durată (descendent)</option>
                            </select>
                            <button type="submit" name="filter-button"
                                class="px-4 py-2 bg-blue-500 text-white rounded">Filtrează</button>
                        </div>
                    </div>
                </div>
            </form>
                <div class="mt-5 relative overflow-x-auto">
                    <table class="text-left w-full bg-white border border-gray-300">
                        <!-- Codul PHP pentru afișarea tabelului și filtrarea rezultatelor -->
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Număr depozit</th>
                                <th class="py-2 px-4 border-b">Titular</th>
                                <th class="py-2 px-4 border-b">Sumă</th>
                                <th class="py-2 px-4 border-b">Durată</th>
                                <th class="py-2 px-4 border-b">Dobândă</th>
                                <th class="py-2 px-4 border-b">Data deschidere</th>
                                <th class="py-2 px-4 border-b">Stare</th>
                                <th class="py-2 px-4 border-b">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Efectuăm interogarea pentru a prelua depozitele din baza de date
                                $query = "SELECT * FROM depozite WHERE 1=1";

                                // Verificați dacă au fost selectate opțiuni de filtrare
                                if (isset($_GET['filter-button'])) {
                                    if (isset($_GET['filter-amount']) && $_GET['filter-amount'] !== 'all') {
                                        $selectedAmount = $_GET['filter-amount'];
                                        $query .= " AND suma_depusa >= " . intval($selectedAmount);
                                    }

                                    if (isset($_GET['filter-duration']) && $_GET['filter-duration'] !== 'all') {
                                        $selectedDuration = $_GET['filter-duration'];
                                        $query .= " AND perioada_depozit >= " . intval($selectedDuration);
                                    }

                                    if (isset($_GET['sort'])) {
                                        $selectedSort = $_GET['sort'];

                                        // Adăugați clauza de sortare în interogare
                                        switch ($selectedSort) {
                                            case "numar-asc":
                                                $query .= " ORDER BY id_depozit ASC";
                                                break;
                                            case "numar-desc":
                                                $query .= " ORDER BY id_depozit DESC";
                                                break;
                                            case "suma-asc":
                                                $query .= " ORDER BY suma_depusa ASC";
                                                break;
                                            case "suma-desc":
                                                $query .= " ORDER BY suma_depusa DESC";
                                                break;
                                            case "durata-asc":
                                                $query .= " ORDER BY perioada_depozit ASC";
                                                break;
                                            case "durata-desc":
                                                $query .= " ORDER BY perioada_depozit DESC";
                                                break;
                                        }
                                    }
                                }

                                $result = mysqli_query($conn, $query);

                                // Verificăm dacă există depozite în rezultat
                                if (mysqli_num_rows($result) > 0) {
                                    // Iterăm prin fiecare rând de depozit
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Extragem informațiile despre depozit din rândul curent
                                        $numarDepozit = $row['id_depozit'];
                                        $idClient = $row['id_client'];
                                        $suma = $row['suma_depusa'];
                                        $durata = $row['perioada_depozit'];
                                        $dobanda = $row['rata_dobanda'];
                                        $dataDeschidere = $row['data_depunere'];

                                        // Verificăm valoarea coloanei 'expirat'
                                        $expirat = $row['expirat'];
                                        if ($expirat == 0) {
                                            $stare = "Activ";
                                        } elseif ($expirat == 1) {
                                            $stare = "Expirat";
                                        }

                                        // Interogăm tabela 'clienti' pentru a obține numele titularului
                                        $queryClient = "SELECT nume FROM inregistrare_client WHERE id_client = $idClient";
                                        $resultClient = mysqli_query($conn, $queryClient);
                                        $rowClient = mysqli_fetch_assoc($resultClient);
                                        $titular = $rowClient['nume'];

                                        // Generăm un rând în tabel pentru depozitul curent
                                        echo "<tr>";
                                        echo "<td class=\"py-2 px-4 border-b\">$numarDepozit</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$titular</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$suma</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$durata luni</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$dobanda</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$dataDeschidere</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">$stare</td>";
                                        // echo "<td class=\"py-2 px-4 border-b\">";
                                        // echo "<form method=\"POST\" action=\"modificare_depozit.php\">";
                                        // echo "<input type=\"hidden\" name=\"id_depozit\" value=\"$numarDepozit\">";
                                        // echo "<button type=\"submit\" class=\"text-blue-500 mr-2\" name=\"modificare\">Modificare</button>";
                                        // echo "</form>";
                                        // echo "</td>";
                                        echo "<td class=\"py-2 px-4 border-b\">";
                                        echo "<form method=\"POST\" action=\"include/sterge_depozit.php\">";
                                        echo "<input type=\"hidden\" name=\"id_depozit\" value=\"$numarDepozit\">";
                                        echo "<button type=\"submit\" class=\"text-red-500\" name=\"sterge\">Ștergere</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // Afisam un mesaj daca nu exista depozite
                                    echo "<tr>";
                                    echo "<td colspan=\"8\" class=\"py-4 px-4 border-b\">Nu există depozite disponibile.</td>";
                                    echo "</tr>";
                                }

                                // Eliberăm memoria rezultatelor interogării
                                mysqli_free_result($result);
                                ?>
                        </tbody>
                    </table>
                </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold">Înregistrări și rapoarte</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                    <form method="POST" action="include/exporta_depozite.inc.php">
                        <div class="bg-white rounded-lg shadow p-4">
                            <h4 class="text-lg font-semibold">Raport financiar</h4>
                            <p class="text-gray-600">Generați un raport financiar detaliat pentru depozitele curente.
                            </p>
                            <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded"
                                name="generate-financial-report">Generați raport</button>
                        </div>
                    </form>
                    <form method="POST" action="include/raport_lunar_depozite.php">
                        <div class="bg-white rounded-lg shadow p-4">
                            <h4 class="text-lg font-semibold">Raport lunar</h4>
                            <p class="text-gray-600">Generați un raport lunar pentru depozitele curente.</p>
                            <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded"
                                name="generate-monthly-report">Generați raport</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<?php require('partials/footer.php') ?>