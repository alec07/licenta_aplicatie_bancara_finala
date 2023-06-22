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
          bg-white">
            <div class="flex justify-between py-4 ">
                <div class=" mb-3 xl:w-96">
                    <div>
                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class=" relative mb-4 flex w-full flex-wrap items-stretch">
                                <input name="search" id="searchInput" type="search"
                                    class="relative m-0 block w-[1%] min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-slate-100  px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none "
                                    placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />
                                <button type="submit"
                                    class="px-4 rounded-lg bg-gray-200  text-gray-800 font-semibold border border-gray-200">Caută</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="justify-self-end ">

                </div>
            </div>
            <!-- titlu -->
            <div class="text-3xl flex justify-left">
                TRANZACȚII / PLĂȚI
            </div>

            <div>
                <div class="flex relative justify-between py-4">

                    <div class="flex items-between mb-2">
                        <form method="POST" class="mb-4">
                            <label for="dataInceput" class="mr-2">Data început:</label>
                            <input type="date" id="dataInceput" name="dataInceput"
                                class="border border-gray-300 rounded px-3 py-2">
                            <label for="dataSfarsit" class="mr-2">Data sfârșit:</label>
                            <input type="date" id="dataSfarsit" name="dataSfarsit"
                                class="border border-gray-300 rounded px-3 py-2">
                            <button type="submit" name="filtrare"
                                class="font-sans font-medium text-sm inline-flex items-center justify-center hover:bg-violet-200 gap-2 h-9 px-6 rounded-full bg-violet-100 text-violet-500 hover:text-violet-600 transition-all duration-300 tw-accessibility">
                                <svg class="h-4 w-4 text-violet-500" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                                </svg>
                                Adauga filtru
                            </button>
                        </form>
                    </div>
                    <button type="submit" name="export" onclick="exportaTransferuri()"
                        class=" ml-auto font-sans font-medium text-sm inline-flex items-center justify-center gap-2  h-9 px-6 rounded-full bg-violet-100 hover:bg-violet-200 text-violet-500 hover:text-violet-600 transition-all duration-300 tw-accessibility ">
                        <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                        </svg>
                        Exporta
                    </button>

                </div>
                <label for="checkbox1">
                    <input type="checkbox" id="checkbox1" value="Cheltuială" onchange="adaugaFiltru()">Cheltuială
                </label>
                <label for="checkbox2">
                    <input type="checkbox" id="checkbox2" value="Venit" onchange="adaugaFiltru()">Venit
                </label>

                <div class="absolute top-50 grid w-[660px] bg-white rounded-lg shadow-lg" id="menu"
                    style="display: none">
                    <div class="flex">
                        <div class="col-span-4 p-6 space-y-2 bg-muted-50 dark:bg-muted-900">

                        </div>
                        <div class=" col-span-8 min-h-[350px] p-6">

                        </div>
                    </div>
                </div>



                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class=" overflow-hidden">

                                <table id="tabel-transferuri"
                                    class=" tabel-transferuri min-w-full text-left text-sm font-light">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">ID</th>
                                            <th scope="col" class="px-6 py-4">De la / Catre</th>
                                            <th scope="col" class="px-6 py-4">Suma</th>
                                            <th scope="col" class="px-6 py-4">Data Transfer</th>
                                            <th scope="col" class="px-6 py-4">Detalii Transfer</th>
                                            <th scope="col" class="px-6 py-4">Debit / Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
// Preluăm ID-ul clientului conectat în sesiune
$id_client = $_SESSION['id_client'];

// Construim interogarea de bază
$query = "SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    CASE
        WHEN transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Cheltuială'
        ELSE 'Venit'
    END AS tip_tranzactie,
    transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    UNION ALL
    SELECT plati_facturi.id_plata, facturieri.nume AS nume_beneficiar, plati_facturi.detalii_transfer,
    'Cheltuială', plati_facturi.suma_plata, plati_facturi.data_plata
    FROM plati_facturi
    JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
    WHERE plati_facturi.id_client = '$id_client'
    UNION ALL
    SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    'Venit', transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')";
// Verificăm dacă a fost trimisă o căutare
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // Interogare cu filtrare după nume beneficiar și detalii transfer
    $query = "SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
                CASE
                    WHEN transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Cheltuială'
                    ELSE 'Venit'
                END AS tip_tranzactie,
                transferuri.suma_transfer, transferuri.data_transfer
                FROM transferuri
                WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
                AND (transferuri.nume_beneficiar LIKE '%$search%' OR transferuri.detalii_transfer LIKE '%$search%')
                UNION ALL
                SELECT plati_facturi.id_plata, facturieri.nume AS nume_beneficiar, plati_facturi.detalii_transfer,
                'Cheltuială', plati_facturi.suma_plata, plati_facturi.data_plata
                FROM plati_facturi
                JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
                WHERE plati_facturi.id_client = '$id_client'
                AND (facturieri.nume LIKE '%$search%' OR plati_facturi.detalii_transfer LIKE '%$search%')";
}
// Verificăm dacă a fost trimisă o filtrare prin formular
if (isset($_POST['filtrare'])) {
    $dataInceput = $_POST['dataInceput'];
    $dataSfarsit = $_POST['dataSfarsit'];

    // Adăugăm condițiile pentru filtrarea după dată în interogare
    if (!empty($dataInceput) && !empty($dataSfarsit)) {
        // Selecționăm transferurile între datele specificate
        $query = "SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    CASE
        WHEN transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Cheltuială'
        ELSE 'Venit'
    END AS tip_tranzactie,
    transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer transferuri.data_transfer BETWEEN '$dataInceput' AND '$dataSfarsit'
    UNION ALL
    SELECT plati_facturi.id_plata, facturieri.nume AS nume_beneficiar, plati_facturi.detalii_transfer,
    'Cheltuială', plati_facturi.suma_plata, plati_facturi.data_plata
    FROM plati_facturi
    JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
    WHERE plati_facturi.id_client = '$id_client'
    AND plati_facturi.data_plata transferuri.data_transfer BETWEEN '$dataInceput' AND '$dataSfarsit'
    UNION ALL
    SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    'Venit', transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer BETWEEN '$dataInceput' AND '$dataSfarsit'";
    } elseif (!empty($dataInceput)) {
        // Selecționăm transferurile după data de început specificată
        $query = "SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    CASE
        WHEN transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Cheltuială'
        ELSE 'Venit'
    END AS tip_tranzactie,
    transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer >= '$dataInceput'
    UNION ALL
    SELECT plati_facturi.id_plata, facturieri.nume AS nume_beneficiar, plati_facturi.detalii_transfer,
    'Cheltuială', plati_facturi.suma_plata, plati_facturi.data_plata
    FROM plati_facturi
    JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
    WHERE plati_facturi.id_client = '$id_client'
    AND plati_facturi.data_plata >= '$dataInceput'
    UNION ALL
    SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    'Venit', transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer BETWEEN '$dataInceput' AND '$dataSfarsit'";
    } elseif (!empty($dataSfarsit)) {
        // Selecționăm transferurile până la data de sfârșit specificată
        $query = "SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    CASE
        WHEN transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Cheltuială'
        ELSE 'Venit'
    END AS tip_tranzactie,
    transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer <= '$dataSfarsit'
    UNION ALL
    SELECT plati_facturi.id_plata, facturieri.nume AS nume_beneficiar, plati_facturi.detalii_transfer,
    'Cheltuială', plati_facturi.suma_plata, plati_facturi.data_plata
    FROM plati_facturi
    JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
    WHERE plati_facturi.id_client = '$id_client'
    AND plati_facturi.data_plata <= '$dataSfarsit'
    UNION ALL
    SELECT transferuri.id_transfer, transferuri.nume_beneficiar, transferuri.detalii_transfer,
    'Venit', transferuri.suma_transfer, transferuri.data_transfer
    FROM transferuri
    WHERE transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
    AND transferuri.data_transfer BETWEEN '$dataInceput' AND '$dataSfarsit'";
    }
}

// Interogăm baza de date pentru a obține transferurile efectuate de către clientul conectat în sesiune
$result = mysqli_query($conn, $query);

// Verificăm dacă există rezultate
if (mysqli_num_rows($result) > 0) {


    // Parcurgem fiecare rând din rezultat și afișăm detaliile transferurilor
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='border-b dark:border-neutral-500'>";
        echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $row['id_transfer'] . "</td>";
        echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['nume_beneficiar'] .  "</td>";
        echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['suma_transfer'] . "</td>";
        echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['data_transfer'] . "</td>";
        echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['detalii_transfer'] . "</td>";
        echo "<td class='whitespace-nowrap px-6 py-4'>" . $row["tip_tranzactie"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    // Afișăm un mesaj dacă nu există rezultate
    echo 'Nu s-au găsit rezultate.';
}
?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function adaugaFiltru() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var selectii = [];

    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selectii.push(checkbox.value);
        }
    });

    var randuri = document.querySelectorAll('#tabel-transferuri tbody tr');

    randuri.forEach(function(rand) {
        var celulaTipTranzactie = rand.querySelector('td:nth-child(6)');
        var tipTranzactie = celulaTipTranzactie.textContent || celulaTipTranzactie.innerText;

        if (selectii.length > 0 && selectii.indexOf(tipTranzactie) === -1) {
            rand.style.display = 'none';
        } else {
            rand.style.display = '';
        }
    });
}

function exportaTransferuri() {
    // Colecționează rândurile tabelului
    var randuri = document.querySelectorAll('.tabel-transferuri tbody tr');

    // Crează un array pentru transferurile filtrate
    var transferuriFiltrate = [];

    // Verifică starea checkbox-urilor
    var checkboxCheltuiala = document.getElementById('checkbox1');
    var checkboxVenit = document.getElementById('checkbox2');
    var filtrareCheltuiala = checkboxCheltuiala.checked;
    var filtrareVenit = checkboxVenit.checked;

    // Filtrează transferurile în funcție de checkbox-uri
    for (var i = 0; i < randuri.length; i++) {
        var rand = randuri[i];
        var celulaTipTranzactie = rand.querySelector('td:nth-child(6)');
        var tipTranzactie = celulaTipTranzactie.textContent || celulaTipTranzactie.innerText;

        if ((filtrareCheltuiala && tipTranzactie === 'Cheltuială') ||
            (filtrareVenit && tipTranzactie === 'Venit')) {
            transferuriFiltrate.push(rand);
        }
    }

    // Verifică dacă există transferuri filtrate
    if (transferuriFiltrate.length > 0) {
        // Creează un element <a> pentru exportul în Excel
        var link = document.createElement('a');
        link.href = 'data:application/vnd.ms-excel;base64,' + encodeExcel(transferuriFiltrate);
        link.download = 'transferuri.xls';
        link.click();
    } else {
        // Nu există transferuri filtrate, afișează un mesaj de avertizare
        alert('Nu există transferuri pentru export.');
    }
}

// Funcția pentru a codifica tabelul în format Excel
function encodeExcel(transferuri) {
    var excel = '<table>';
    for (var i = 0; i < transferuri.length; i++) {
        excel += transferuri[i].outerHTML;
    }
    excel += '</table>';

    var base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)));
    };

    var formatExcel = function(s) {
        return '<tr><td>' + s.replace(/\n/g, '</td></tr><tr><td>') + '</td></tr>';
    };

    return base64(formatExcel(excel));
}
</script>

<?php require('partials/footer.php') ?>