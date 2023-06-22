<?php
    require_once('include/db.inc.php');
    $sql=" SELECT * FROM inregistrare_client WHERE user_type = 'user' ";
    $result = $conn->query($sql);
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
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
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
                                    <form method="post" action="include/sterge_client.inc.php">
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
<?php require('partials/footer.php') ?>