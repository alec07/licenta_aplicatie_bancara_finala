<?php include('include/db.inc.php');
session_start(); ?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>


<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
        <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Tranzactii</h1>
        <div class="flex justify-between">
            <button type="button"
                class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Adauga
                filtru</button>
            <button type="button"
                class=" justify-right text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Exporta</button>
        </div>

        <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-CENTER text-gray-500 ">
                <thead class="">
                    <tr>
                        <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                            ID
                        </th>
                        <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                            DE LA
                        </th>
                        <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                            CATRE
                        </th>
                        <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                            SUMA
                        </th>
                        <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                            DATA
                        </th>
                    </tr>
                </thead>
                <tbody><?php

// Interogare SQL pentru a afișa toate transferurile și numele clienților implicați
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
       ";

$result = mysqli_query($conn, $sql);

// Verificare rezultate
if (mysqli_num_rows($result) > 0) {
  // Afisare tabel cu transferurile și numele clienților implicați

  while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td class=' px-4 py-2'>" . $row["id_transfer"] . "</td>
            <td class=' px-4 py-2'>" . $row["nume_sursa"] ." ".$row["prenume_sursa"] . "</td>
            <td class=' px-4 py-2'>" . $row["nume_destinatie"] ." ".$row["prenume_destinatie"] . "</td>
            <td class=' px-4 py-2'>" . $row["suma_transfer"] . "</td>
            <td class=' px-4 py-2'>" . $row["data_transfer"] . "</td>
          </tr>";
  }

} else {
  echo "Nu s-au gasit transferuri.";
}

// Inchidere conexiune la baza de date
mysqli_close($conn);
?>



                    <!-- <tr class="bg-white  dark:bg-gray-800 l">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            $2999
                        </td>
                    </tr>
                    <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Microsoft Surface Pro
                        </th>
                        <td class="px-6 py-4">
                            White
                        </td>
                        <td class="px-6 py-4">
                            Laptop PC
                        </td>
                        <td class="px-6 py-4">
                            $1999
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Magic Mouse 2
                        </th>
                        <td class="px-6 py-4">
                            Black
                        </td>
                        <td class="px-6 py-4">
                            Accessories
                        </td>
                        <td class="px-6 py-4">
                            $99
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>

</div>



<?php require('partials/footer.php') ?>