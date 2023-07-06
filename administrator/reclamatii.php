<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-5">Reclamatii</h1>
                    <?php include ('partials/form_cautare.php'); ?>
                    <div class="flex justify-between">
                        <label for="checkbox1">
                            <input type="checkbox" id="checkbox1" value="Altele"> Altele
                        </label>
                        <label for="checkbox2">
                            <input type="checkbox" id="checkbox2" value="Tranzactii"> Tranzactii
                        </label>
                        <label for="checkbox3">
                            <input type="checkbox" id="checkbox3" value="Depozite"> Depozite
                        </label>
                        <button type="button" onclick="adaugaFiltru()"
                            class="text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2  mb-2">
                            Adaugă filtru
                        </button>
                        <button type="button"
                            class="justify-right text-slate-600 bg-slate-100 focus:outline-none hover:bg-slate-200 font-medium rounded-full text-xs px-5 py-2  mb-2">
                            <a href="include/exporta_reclamatii.inc.php">Exporta</a>
                        </button>
                    </div>


                </div>
                <div class="tabel-reclamatii">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead>
                            <tr>
                                <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                    NR. RECLAMATIE
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                                <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                    NUME RECLAMANT
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                                <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                    NR. TELEFON
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                                <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                    SUBIECT
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                                <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                    MESAJ
                                    <button onclick="sortTable(0, 'asc')">▲</button>
                                    <button onclick="sortTable(0, 'desc')">▼</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
// Verificăm dacă a fost trimis un termen de căutare
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // Interogare SQL inițială pentru a afișa toate reclamațiile
    $sql = "SELECT * FROM formular_reclamatii";

    // Verificăm dacă a fost selectat un filtru
    $selectedCheckboxes = $_GET['checkbox'] ?? array();
    if (!empty($selectedCheckboxes)) {
        $checkboxValues = implode("','", $selectedCheckboxes);
        $filterSql = "subiect_reclamatie IN ('$checkboxValues')";
        $sql .= " WHERE $filterSql";
    }

    $result = mysqli_query($conn, $sql);

    // Verificare rezultate
    if (mysqli_num_rows($result) > 0) {
        // Cream un array pentru a stoca doar rezultatele filtrate
        $filteredResults = array();

        // Filtrăm rezultatele pe baza subiectului reclamației
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row["subiect_reclamatie"], $searchTerm) !== false || stripos($row["nume_reclamant"], $searchTerm) !== false || stripos($row["prenume_reclamant"], $searchTerm) !== false || stripos($row["mesaj_reclamatie"], $searchTerm) !== false) {
                $filteredResults[] = $row;
            }
        }

        // Verificăm dacă există rezultate filtrate
        if (!empty($filteredResults)) {
            // Afisare tabel cu reclamațiile filtrate și căutate
            foreach ($filteredResults as $row) {
                echo "
                    <tr>
                        <td class='px-4 py-2'>" . $row["id"] . "</td>
                        <td class='px-4 py-2'>" . $row["nume_reclamant"] ." ".$row["prenume_reclamant"] . "</td>
                        <td class='px-4 py-2'>" . $row["nr_telefon"] ." </td>
                        <td class='px-4 py-2'>" . $row["subiect_reclamatie"] . "</td>
                        <td class='px-4 py-2'>" . $row["mesaj_reclamatie"] . "</td>
                    </tr>";
            }
        } else {
            echo "Nu s-au găsit rezultate pentru termenul de căutare și filtrul selectat.";
        }
    } else {
        echo "Nu s-au găsit rezultate pentru filtrul selectat.";
    }
} else {
    // Verificăm dacă a fost selectat un filtru
    $selectedCheckboxes = $_GET['checkbox'] ?? array();
    if (!empty($selectedCheckboxes)) {
        $checkboxValues = implode("','", $selectedCheckboxes);
        $filterSql = "subiect_reclamatie IN ('$checkboxValues')";
        $sql .= " WHERE $filterSql";
    } else {
        $sql = "SELECT * FROM formular_reclamatii";
    }

    $result = mysqli_query($conn, $sql);

    // Verificare rezultate
    if (mysqli_num_rows($result) > 0) {
        // Afisare tabel cu toate reclamațiile
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
                <tr>
                    <td class='px-4 py-2'>" . $row["id"] . "</td>
                    <td class='px-4 py-2'>" . $row["nume_reclamant"] ." ".$row["prenume_reclamant"] . "</td>
                    <td class='px-4 py-2'>" . $row["nr_telefon"] ." </td>
                    <td class='px-4 py-2'>" . $row["subiect_reclamatie"] . "</td>
                    <td class='px-4 py-2'>" . $row["mesaj_reclamatie"] . "</td>
                </tr>";
        }
    } else {
        echo "Nu s-au găsit rezultate pentru filtrul selectat.";
    }
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

            if (order === "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (order === "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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