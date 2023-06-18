<?php require('partials/head.php') ?>
<?php require_once('include/db.inc.php'); ?>
<?php include ('partials/sidebar.php'); ?>

<div class="p-4 sm:ml-64">

    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
                    <h1>ADMINISTRAREA CONȚINUTULUI PAGINILOR WEB</h1>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    PAGINI
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    EDITARE </th>
                                <th scope="col" class="px-6 py-2">
                                    ISTORIC </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php
                                // selectare date din tabel
                                $sql = "SELECT * FROM pagini_continut";
                                $result = $conn->query($sql);

                                // afișare date în tabel
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr class='bg-white'>";
                                        echo "<td class='px-6 py-2'>" . $row["pagini"] . "</td>";
                                        echo "<td class='px-6 py-2'><a href='editare_content_pagini.php?id_pagina=" . $row["id_pagina"] . "'>Edit</a></td>";
                                        echo "<td class='px-6 py-2'><a href='istoric_pagina_content.php?id_pagina=" . $row["id_pagina"] . "'>Istoric</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Nu sunt adaugate pagini</td></tr>";
                                }
                            ?>
                        </tbody>

                    </table>
                    <div class="mb-6">

                        <br></br>

                        <!-- Butonul de adăugare -->
                        <button
                            class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-normal text-xs py-2 px-6 rounded-full"
                            onclick="showAddForm()">Adaugă pagina</button>

                        <!-- Formularul de adăugare utilizator -->
                        <div id="add-form" class="hidden">
                            <form action="include/adauga_pagina.inc.php" method="POST" class="mt-4">
                                <label class="block text-gray-500 text-sm">Nume pagina:</label>
                                <input type="text" name="nume_pagina" class=" rounded py-2 px-4 mb-2 w-full">
                                <button type="submit"
                                    class="hover:bg-emerald-50 text-emerald-400 font-normal py-1 px-1 rounded-xl ">Adaugă</button>
                            </form>
                        </div>

                    </div>

                </div>
                <br>
            </div>

        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>