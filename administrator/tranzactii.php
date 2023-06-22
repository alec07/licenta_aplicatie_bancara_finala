<?php include('include/db.inc.php');
session_start(); ?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>
<?php
// Verificăm dacă există cererea POST pentru filtrare
if (isset($_POST['filtrare'])) {
    $dataInceput = $_POST['dataInceput'];
    $dataSfarsit = $_POST['dataSfarsit'];

    // Realizați interogarea bazei de date pentru a filtra în funcție de perioadă
    $sql = "SELECT * FROM transferuri WHERE data_transfer BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $dataInceput, $dataSfarsit);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // Dacă nu există o cerere de filtrare, afișăm toate înregistrările
    $sql = "SELECT * FROM transferuri";
    $result = mysqli_query($conn, $sql);
}
?>

<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Tranzactii</h1>
                    <?php include ('partials/form_cautare.php'); ?>
                    <!-- Adăugați formularul pentru filtrare în partea de sus a tabelului -->
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
                            <button type="button"
                                class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 "><a
                                    href="include/exporta_utilizatori.inc.php"> Exporta</a></button>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-2">
                                        ID
                                        <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        DE LA
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        CATRE
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
                                    $sql = "SELECT t.id_transfer,
                                                sursa.nume AS nume_sursa,
                                                sursa.prenume AS prenume_sursa,
                                                destinatie.nume AS nume_destinatie,
                                                destinatie.prenume AS prenume_destinatie,
                                                t.suma_transfer,
                                                t.data_transfer
                                            FROM transferuri t
                                            JOIN conturi c1 ON t.id_client_sursa = c1.id_cont
                                            JOIN inregistrare_client sursa ON c1.id_client = sursa.id_client
                                            JOIN conturi c2 ON t.id_client_destinatie = c2.id_cont
                                            JOIN inregistrare_client destinatie ON c2.id_client = destinatie.id_client
                                            WHERE t.data_transfer BETWEEN ? AND ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("ss", $dataInceput, $dataSfarsit);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                } else if (isset($_GET['search'])) {
                                    $search = $_GET['search'];

                                    // Interogare SQL pentru a afișa transferurile și numele clienților implicați, cu condiția de căutare
                                    $sql = "SELECT t.id_transfer,
                                                sursa.nume AS nume_sursa,
                                                sursa.prenume AS prenume_sursa,
                                                destinatie.nume AS nume_destinatie,
                                                destinatie.prenume AS prenume_destinatie,
                                                t.suma_transfer,
                                                t.data_transfer
                                            FROM transferuri t
                                            JOIN conturi c1 ON t.id_client_sursa = c1.id_cont
                                            JOIN inregistrare_client sursa ON c1.id_client = sursa.id_client
                                            JOIN conturi c2 ON t.id_client_destinatie = c2.id_cont
                                            JOIN inregistrare_client destinatie ON c2.id_client = destinatie.id_client
                                            WHERE sursa.nume LIKE '%$search%'
                                            OR sursa.prenume LIKE '%$search%'
                                            OR destinatie.nume LIKE '%$search%'
                                            OR destinatie.prenume LIKE '%$search%'";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    // Dacă nu există o cerere de filtrare sau de căutare, afișăm toate transferurile și numele clienților implicați
                                    $sql = "SELECT t.id_transfer,
                                                sursa.nume AS nume_sursa,
                                                sursa.prenume AS prenume_sursa,
                                                destinatie.nume AS nume_destinatie,
                                                destinatie.prenume AS prenume_destinatie,
                                                t.suma_transfer,
                                                t.data_transfer
                                            FROM transferuri t
                                            JOIN conturi c1 ON t.id_client_sursa = c1.id_cont
                                            JOIN inregistrare_client sursa ON c1.id_client = sursa.id_client
                                            JOIN conturi c2 ON t.id_client_destinatie = c2.id_cont
                                            JOIN inregistrare_client destinatie ON c2.id_client = destinatie.id_client";
                                    $result = mysqli_query($conn, $sql);
                                }
                                ?>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    // Afișare tabel cu transferurile și numele clienților implicați
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td class='px-4 py-2'>" . $row["id_transfer"] . "</td>
                                                <td class='px-4 py-2'>" . $row["nume_sursa"] . " " . $row["prenume_sursa"] . "</td>
                                                <td class='px-4 py-2'>" . $row["nume_destinatie"] . " " . $row["prenume_destinatie"] . "</td>
                                                <td class='px-4 py-2'>" . $row["suma_transfer"] . "</td>
                                                <td class='px-4 py-2'>" . $row["data_transfer"] . "</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "Nu s-au găsit transferuri.";
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

<script>
function sortTable(column, order) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector("table");
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[column];
            y = rows[i + 1].getElementsByTagName("TD")[column];

            var xValue = x.innerHTML.toLowerCase();
            var yValue = y.innerHTML.toLowerCase();

            if (order === "asc") {
                if (xValue > yValue) {
                    shouldSwitch = true;
                    break;
                }
            } else if (order === "desc") {
                if (xValue < yValue) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
</script>

<?php require('partials/footer.php') ?>