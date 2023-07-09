<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <div class="w-full ">
                <div class="text-center mb-12 ">
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-5">Raport - Tranzactii</h1>
                    <p class="text-xs text-slate-800 justify-left flex mb-5">*pentru un raport mai detaliat, filtrează
                        după dată, apoi caută după nume</p>

                    <?php include ('partials/form_cautare.php'); ?>
                    <!-- formular pentru filtrare în partea de sus a tabelului -->
                    <div class="flex justify-between">
                        <div class="flex items-between mb-2">
                            <form method="POST" class="mb-4">
                                <label for="dataInceput" class="mr-2">Data început:</label>
                                <input type="date" id="dataInceput" name="dataInceput"
                                    class="border border-gray-300 rounded px-3 py-2">
                                <label for="dataSfarsit" class="mr-2">Data sfârșit:</label>
                                <input type="date" id="dataSfarsit" name="dataSfarsit"
                                    class="border border-gray-300 rounded px-3 py-2">

                                <button type="submit" name="filtrare"
                                    class="text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2  mb-2">Filtrează</button>
                            </form>
                        </div>
                        <div>
                            <!-- <form method="POST" action="include/exporta_plati.inc.php">
                                <div>
                                    <button type="submit" name="export"
                                        class="justify-right text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2 mb-2">
                                        Exporta
                                    </button>
                                </div>
                            </form> -->
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-2">
                                        Numar plata
                                        <button onclick="sortTable(0, 'asc')">▲</button>
                                        <button onclick="sortTable(0, 'desc')">▼</button>
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        DE LA: Nume Client
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        CATRE: Nume Beneficiar
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        SUMA
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        DATA
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                // Verificăm dacă există cererea POST pentru filtrare
                                if (isset($_POST['filtrare'])) {
                                    $dataInceput = $_POST['dataInceput'];
                                    $dataSfarsit = $_POST['dataSfarsit'];

                                    // Realizați interogarea bazei de date pentru a filtra în funcție de perioadă
                                    $sql = "SELECT pf.id_plata, pf.data_plata, pf.suma_plata, ic.nume AS nume_client, ic.prenume AS prenume_client, f.nume AS nume_facturier
                                    FROM plati_facturi AS pf
                                    JOIN inregistrare_client AS ic ON pf.id_client = ic.id_client
                                    JOIN facturieri AS f ON pf.id_facturier = f.id_facturier
                                    JOIN conturi AS c ON ic.id_client = c.id_client
                                            WHERE  data_plata BETWEEN ? AND ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("ss", $dataInceput, $dataSfarsit);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else if (isset($_GET['search'])) {
                                    $search = $_GET['search'];

                                    // Interogare SQL pentru a afișa plataurile și numele clienților implicați, cu condiția de căutare
                                    $sql = "SELECT pf.id_plata, pf.data_plata, pf.suma_plata, ic.nume AS nume_client, ic.prenume AS prenume_client, f.nume AS nume_facturier
                                    FROM plati_facturi AS pf
                                    JOIN inregistrare_client AS ic ON pf.id_client = ic.id_client
                                    JOIN facturieri AS f ON pf.id_facturier = f.id_facturier
                                    JOIN conturi AS c ON ic.id_client = c.id_client
                                    WHERE ic.nume LIKE '%$search%'
                                    OR ic.prenume LIKE '%$search%'
                                    OR f.nume LIKE '%$search%'";


                                     if (isset($_POST['filtrare'])) {
                                        $dataInceput = $_POST['dataInceput'];
                                        $dataSfarsit = $_POST['dataSfarsit'];

                                        // Adăugăm condiția de filtrare după dată în interogarea SQL
        // Adăugăm condiția de filtrare după dată în interogarea SQL, limitată doar la rezultatele căutării actuale
        $sql .= " AND (t.data_plata BETWEEN '$dataInceput' AND '$dataSfarsit')";
    }

    $result = mysqli_query($conn, $sql);

                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    // Dacă nu există o cerere de filtrare sau de căutare, afișăm toate plataurile și numele clienților implicați
                                    $sql = "SELECT pf.id_plata, pf.data_plata, pf.suma_plata, ic.nume AS nume_client, ic.prenume AS prenume_client, f.nume AS nume_facturier
                                    FROM plati_facturi AS pf
                                    JOIN inregistrare_client AS ic ON pf.id_client = ic.id_client
                                    JOIN facturieri AS f ON pf.id_facturier = f.id_facturier
                                    JOIN conturi AS c ON ic.id_client = c.id_client";
                                    $result = mysqli_query($conn, $sql);
                                }
                                ?>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    // Afișare tabel cu plataurile și numele clienților implicați
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td class='px-4 py-2'>" . $row["id_plata"] . "</td>
                                                <td class='px-4 py-2'>" .$row['nume_client']." " .$row['prenume_client']. "</td>
                                                <td class='px-4 py-2'>" .$row['nume_facturier']. "</td>
                                                <td class='px-4 py-2'>" . $row["suma_plata"] . "</td>
                                                <td class='px-4 py-2'>" . $row["data_plata"] . "</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "Nu s-au găsit plati.";
                                }

                                // Închidere conexiune la baza de date
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

<?php require('partials/footer.php') ?>