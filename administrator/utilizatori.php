<?php
    require('include/db.inc.php');
    $sql=" SELECT * FROM inregistrare_client WHERE user_type = 'user' ";
    $result = $conn->query($sql);
?>


<?php
// Interogare pentru numărul de conturi deschise
$queryConturiDeschise = "SELECT COUNT(*) as numar_conturi_deschise FROM inregistrare_client where user_type='user' ";
$resultConturiDeschise = $conn->query($queryConturiDeschise);
$rowConturiDeschise = $resultConturiDeschise->fetch_assoc();
$conturiDeschise = $rowConturiDeschise['numar_conturi_deschise'];

// Interogare pentru numărul de conturi închise
$queryConturiInchise = "SELECT COUNT(*) as numar_conturi_inchise FROM conturi_sterse ";
$resultConturiInchise = $conn->query($queryConturiInchise);
$rowConturiInchise = $resultConturiInchise->fetch_assoc();
$conturiInchise = $rowConturiInchise['numar_conturi_inchise'];

// Calcularea procentului de conturi deschise și închise
$procentConturiDeschise = ($conturiDeschise / ($conturiDeschise + $conturiInchise)) * 100;
$procentConturiInchise = ($conturiInchise / ($conturiDeschise + $conturiInchise)) * 100;
?>
<?php

$query = "SELECT * FROM inregistrare_client  WHERE user_type = 'user'";
$result2 = mysqli_query($conn, $query);
$total_utilizatori = mysqli_num_rows($result2);
$query="SELECT * FROM conturi_sterse";
$result2 = mysqli_query($conn, $query);
$total_sterse = mysqli_num_rows($result2);
// Interogare pentru utilizatorii care au efectuat cel puțin o plată
$queryPlati = "SELECT COUNT(DISTINCT id_client) as numar_plati FROM plati_facturi";
$resultPlati = mysqli_query($conn, $queryPlati);
$rowPlati = mysqli_fetch_assoc($resultPlati);
$numarPlati = $rowPlati['numar_plati'];


?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>
<?php
// Verificăm dacă există cererea POST pentru filtrare
if (isset($_POST['filtrare'])) {
    $dataInceput = $_POST['dataInceput'];
    $dataSfarsit = $_POST['dataSfarsit'];

  // Realizați interogarea bazei de date pentru a filtra în funcție de perioadă
$query = "SELECT * FROM inregistrare_client WHERE user_type = 'user' AND ((data_nastere BETWEEN '$dataInceput' AND '$dataSfarsit') OR (data_deschidere BETWEEN '$dataInceput' AND '$dataSfarsit'))";

$result = $conn->query($query);


}
else{
    // Dacă nu există o cerere de filtrare, afișăm toate înregistrările
    $query = "SELECT * FROM inregistrare_client  WHERE user_type = 'user'";
    $result = mysqli_query($conn, $query);
}
?>


<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class="mb-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold mb-4">Indicatori cheie</h2>
                        <div class="flex flex-wrap justify-between items-center">
                            <div class="flex flex-col items-center">
                                <h3 class="text-xl font-semibold">Total utilizatori</h3>
                                <p class="text-gray-600"><?php echo $total_utilizatori; ?></p>
                            </div>

                            <div class="flex flex-col items-center">
                                <h3 class="text-xl font-semibold">Conturi inchise</h3>
                                <p class="text-gray-600"><?php echo $total_sterse; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                        <h2 class="text-lg font-semibold mb-4">Grafic evoluție utilizatori</h2>
                        <div class="bg-gray-200 h-60 w-90">
                            <canvas id="graficUtilizatori"></canvas>
                        </div>
                    </div>
                </div>
                <div class=" text-sm  mb-12 ">
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Utilizatori</h1>
                    <?php include ('partials/form_cautare.php'); ?>
                    <!-- <button type="button" onclick="adaugaFiltru()"
                        class="text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2  mb-2">
                        Adaugă filtru
                    </button> -->
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
                        <form method="POST" action="include/exporta_utilizatori.inc.php">
                            <div>
                                <button type="submit" name="export"
                                    class="justify-right text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2 mb-2">
                                    Exporta
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Afișați tabelul cu rezultatele filtrate sau toate înregistrările -->
                    <table class="w-full text-sm text-center text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    id client
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    nume client

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    initiala tata
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    prenume client

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    data nastere

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    nume județ

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    data deschidere cont

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    editare date cont

                                </th>
                                <th scope="col" class="px-6 py-2">
                                    stergere cont
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['search'])) {
                                $search = $_GET['search'];

                                // Adăugați condiția de căutare în interogarea inițială
                                $query .= " AND (nume LIKE '%$search%' OR prenume LIKE '%$search%')";
                            }
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Afișați înregistrările în tabel
                                    $id_oras = $row['oras'];
                                    // Realizam o interogare suplimentară pentru a obține numele orașului bazat pe ID-ul orașului
                                    $query_oras = "SELECT nume_oras FROM orase WHERE id_oras = $id_oras";
                                    $result_oras = mysqli_query($conn, $query_oras);
                                    $oras = mysqli_fetch_assoc($result_oras)['nume_oras'];
                                    ?>
                            <tr>
                                <td class="px-4 py-2"><?php echo $row['id_client']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['nume']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['initiala_t']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['prenume']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['data_nastere']; ?></td>
                                <td class="px-4 py-2">
                                    <?php
                                // Afișați numele orașului în loc de ID
                                echo $oras;
                                ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?php
                                        $timestamp = $row['data_deschidere'];
                                        $data = date('Y-m-d', strtotime($timestamp));
                                        echo $data;
                                ?>
                                </td>
                                <td class="border-none hover:bg-violet-50 px-3 py-1 rounded text-indigo-500 m-5">
                                    <button>
                                        <a
                                            href="formular_editare_client.php?id_client=<?php echo $row['id_client']; ?>">Edit</a>
                                    </button>
                                </td>
                                <td>
                                    <form method="POST" action="include/sterge_client.inc.php">
                                        <input type="hidden" name="id_client" value="<?php echo $row['id_client']; ?>">
                                        <button onclick="return confirm('Sigur doriți să ștergeți acest client?')"
                                            class="hover:bg-red-50 px-3 py-1 rounded text-red-500" name="delete"
                                            type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Nu există înregistrări disponibile.</td></tr>";
                                }
                                ?>

                        </tbody>
                    </table>
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


function adaugaFiltru() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var selectii = [];

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selectii.push(checkbox.value);
        }
    });

    var randuri = document.querySelectorAll('.tabel-reclamatii tbody tr');

    randuri.forEach(function(rand) {
        var celulaSubiect = rand.querySelector('td:nth-child(4)');
        var subiect = celulaSubiect.textContent || celulaSubiect.innerText;

        if (selectii.length > 0 && selectii.indexOf(subiect) === -1) {
            rand.style.display = 'none';
        } else {
            rand.style.display = '';
        }
    });
}
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datele preluate din PHP
var conturiDeschise = <?php echo $conturiDeschise; ?>;
var conturiInchise = <?php echo $conturiInchise; ?>;
var procentConturiDeschise = <?php echo $procentConturiDeschise; ?>;
var procentConturiInchise = <?php echo $procentConturiInchise; ?>;

// Creați un nou grafic utilizând Chart.js
var ctx = document.getElementById('graficUtilizatori').getContext('2d');
var graficUtilizatori = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Conturi deschise', 'Conturi închise'],
        datasets: [{
            data: [procentConturiDeschise, procentConturiInchise],
            backgroundColor: ['#36A2EB', '#FF6384'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        cutoutPercentage: 80,
        legend: {
            display: false
        }
    }
});
</script>
<script>
function filtrareUtilizatori() {
    var select = document.getElementById("filtrareUtilizatori");
    var option = select.options[select.selectedIndex].value;

    // Redirectați utilizatorul către aceeași pagină, dar adăugați parametrul "filter" în URL
    window.location.href = window.location.pathname + "?filter=" + option;
}
</script>

<?php require('partials/footer.php') ?>