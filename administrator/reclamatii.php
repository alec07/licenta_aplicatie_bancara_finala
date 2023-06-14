<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>




<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <div class="mb-5" >
                <h1 class="text-3xl text-slate-800 justify-left flex mb-5">Reclamatii</h1>
                <div class="flex justify-between">
                    <button type="button"
                        class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Adauga filtru</button>
                    <button type="button"
                        class=" justify-right text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Exporta</button>
                </div>
            </div>
            <div>
                <table class="w-full text-sm text-left text-gray-500 ">
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                NR. RECLAMATIE
                            </th>
                            <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                NUME RECLAMANT
                            </th>
                            <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                NR. TELEFON
                            </th>
                            <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                SUBIECT
                            </th>
                            <th scope="col" class="text-slate-500 text-sm font-medium px-4 py-2">
                                MESAJ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Interogare SQL pentru a afișa toate transferurile și numele clienților implicați
                            $sql = "SELECT * FROM formular_reclamatii";
                            $result = mysqli_query($conn, $sql);
                            // Verificare rezultate
                            if (mysqli_num_rows($result) > 0) {
                            // Afisare tabel cu transferurile și numele clienților implicați
                            while($row = mysqli_fetch_assoc($result)) {
                                echo"
                                    <tr>
                                        <td class=' px-4 py-2'>" . $row["id"] . "</td>
                                        <td class=' px-4 py-2'>" . $row["nume_reclamant"] ." ".$row["prenume_reclamant"] . "</td>
                                        <td class=' px-4 py-2'>" . $row["nr_telefon"] ." </td>
                                        <td class=' px-4 py-2'>" . $row["subiect_reclamatie"] . "</td>
                                        <td class=' px-4 py-2'>" . $row["mesaj_reclamatie"] . "</td>
                                    </tr>";
                                }

                            } else {
                            echo "Nu s-au gasit transferuri.";
                            }

                            // Inchidere conexiune la baza de date
                            mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<?php require('partials/footer.php') ?>