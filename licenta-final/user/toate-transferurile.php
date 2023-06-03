<?php
include('includes/db.inc.php');
session_start();
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <?php require('partials/sidebar.php')?>

    <div class="p-4 sm:ml-64">
        <div class="
          w-full
          max-w-6xl
          min-h-screen
          mx-auto
          bg-white
          dark:bg-violet-900">

            <div class="flex justify-between py-4 ">
                <div class=" mb-3 xl:w-96">
                    <form action="" onsubmit="search(); return false;">
                    <div class=" relative mb-4 flex w-full flex-wrap items-stretch">
                        <input id="searchInput" type="search"
                            class="relative m-0 block w-[1%] min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-slate-100  px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none "
                            placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />
                    </div>
                    </form>
                </div>
                <div class="justify-self-end ">

                </div>
            </div>
            <!-- titlu -->
            <div class="text-3xl flex justify-left">
                TRANZACȚII / PLĂȚI
            </div>
            <div>
                <?php require('partials/butons-filter-export.php') ?>
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
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">ID</th>
                                            <th scope="col" class="px-6 py-4">De la / Catre</th>
                                            <th scope="col" class="px-6 py-4">Suma</th>
                                            <th scope="col" class="px-6 py-4">Data Transfer</th>
                                            <th scope="col" class="px-6 py-4">Debit / Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Preluăm ID-ul clientului conectat în sesiune
                                            $id_client = $_SESSION['id_client'];

                                            // Interogăm baza de date pentru a obține toate transferurile efectuate de către clientul conectat în sesiune
                                            $query = "SELECT transferuri.id_transfer,  inregistrare_client.nume AS nume_destinatar,
                                            inregistrare_client.prenume AS prenume_destinatar,
                                            CASE
                                              WHEN transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client') THEN 'Credit'
                                              ELSE 'Debit'
                                            END AS tip_tranzactie,
                                            transferuri.suma_transfer, transferuri.data_transfer
                                            FROM transferuri
                                            JOIN conturi ON transferuri.id_client_destinatie = conturi.id_cont
                                            JOIN inregistrare_client ON conturi.id_client = inregistrare_client.id_client
                                            WHERE transferuri.id_client_sursa = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
                                            OR transferuri.id_client_destinatie = (SELECT id_cont FROM conturi WHERE id_client = '$id_client')
                                            UNION ALL
                                            SELECT plati_facturi.id_plata, facturieri.nume AS nume_destinatar,
                                            '', 'Debit', plati_facturi.suma_plata, plati_facturi.data_plata
                                            FROM plati_facturi
                                            JOIN facturieri ON plati_facturi.id_facturier = facturieri.id_facturier
                                            WHERE plati_facturi.id_client = '$id_client'";
                                            $result = mysqli_query($conn, $query);

                                            // Parcurgem fiecare rând din rezultat și afișăm detaliile transferurilor
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                // Afisam detaliile transferului intr-un rand al tabelului
                                                echo "<tr class='border-b dark:border-neutral-500'>";
                                                echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $row['id_transfer'] . "</td>";
                                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['nume_destinatar'] ." ".  $row['prenume_destinatar'] ."</td>";
                                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['suma_transfer'] . "</td>";
                                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $row['data_transfer'] . "</td>";
                                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $row["tip_tranzactie"] . "</td>";


                                                echo "</tr>";
                                                echo "</tr>";
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
function toggleMenu() {
    var menu = document.getElementById('menu');
    if (menu.style.display === 'none') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
};

function search() {
  var searchTerm = document.getElementById("searchInput").value;
  window.location.href = "includes/search.php?query=" + searchTerm;
}

</script>

<?php require('partials/footer.php') ?>