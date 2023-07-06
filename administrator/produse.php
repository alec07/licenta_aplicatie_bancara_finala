<?php
    include_once 'include/db.inc.php';
?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>


<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm  mb-12 ">
                    <?php
                        // Verificăm dacă există un mesaj de afișat
                        if(isset($_GET['msg'])){
                            $msg = $_GET['msg'];
                            echo "<p>".$msg."</p>";
                        }
                    ?>
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Produsele Bancare acceptate - Pagina de
                        Administrare</h1>
                    <?php include ('partials/form_cautare.php'); ?>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-gray-500 ">
                            <thead class="text-xs text-left text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-2">
                                        nume produs
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        id_produs
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        editare
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        stergere
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php

                                // Verificăm dacă a fost trimis un termen de căutare
                                if (isset($_GET['search'])) {
                                    $searchTerm = $_GET['search'];
                                // selectare date din tabel
                                $sql=" SELECT * FROM produse_bancare WHERE nume_produs LIKE '%$searchTerm%'";
                                $result = $conn->query($sql);
                                // afișare date în tabel
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr class='bg-white '><td class='px-6 py-2'>" . $row["nume_produs"]  . "</td><td>" . $row["id_produs"]. "</td><td><a href='produse.php?id_produs=" . $row["id_produs"] . "'>Edit</a></td><td><a onclick='return confirm(\"Sigur doriți să ștergeți acest client?\")' href='include/sterge_produs.inc.php?id_produs=" . $row["id_produs"] . "'>Sterge</a></td></tr>";
                                    }
                                    } else {
                                        echo "<tr><td colspan='4'>Nu sunt adaugate produse_bancare</td></tr>";
                                    }
                                } else {
                                // selectare date din tabel
                                $sql=" SELECT * FROM produse_bancare ";
                                $result = $conn->query($sql);
                                // afișare date în tabel
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr class='bg-white '><td class='px-6 py-2'>" . $row["nume_produs"]  . "</td><td>" . $row["id_produs"]. "</td><td><a href='produse.php?id_produs=" . $row["id_produs"] . "'>Edit</a></td><td><a onclick='return confirm(\"Sigur doriți să ștergeți acest client?\")' href='include/sterge_produs.inc.php?id_produs=" . $row["id_produs"] . "'>Sterge</a></td></tr>";
                                    }
                                    } else {
                                        echo "<tr><td colspan='4'>Nu sunt adaugate produse_bancare</td></tr>";
                                    }
                                    }
                            ?>
                            </tbody>
                        </table>
                        <div class="mb-6">
                            <?php
                                include_once 'include/db.inc.php';
                                // verifică dacă butonul de edit a fost apăsat
                                if (isset($_POST["edit"])) {
                                // preia datele din formular
                                $id_produs = $_POST["id_produs"];
                                $nume_produs = $_POST["nume_produs"];

                                // actualizează datele în baza de date
                                $sql = "UPDATE produse_bancare SET nume_produs='$nume_produs' WHERE id_produs='$id_produs'";
                                if (mysqli_query($conn, $sql)) {
                                        echo "Date actualizate cu succes";
                                        echo "<script>setTimeout(function(){window.location.href='produse.php'},1000);</script>";
                                        }
                                    else {
                                        echo "Eroare la actualizarea datelor: " . mysqli_error($conn);
                                    }
                                }

                                // afișare formular pentru editare
                                if (isset($_GET["id_produs"])) {
                                    $id_produs = $_GET["id_produs"];

                                    // preia datele utilizatorului din baza de date
                                    $sql = "SELECT id_produs , nume_produs FROM produse_bancare WHERE id_produs='$id_produs'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);

                                    // afișare formular pentru editare
                                    echo "<h2 class='mt-2 text-sm text-slate-500 uppercase mb-5'>Editare produs</h2>";
                                    echo "<form class='ml-6' method='post'>";
                                    echo "<input type='hidden' name='id_produs' value='" . $row["id_produs"] . "'>";
                                    echo "Nume Produs: <input class='ml-2' type='text' name='nume_produs' value='" . $row["nume_produs"] . "'>";
                                    echo "<br><br>";
                                    echo "<input class='text-emerald-500 font-bold uppercase' type='submit' name='edit' value='Salveaza'>";
                                    echo "</form>";
                                }
                            ?>
                            <br></br>

                            <!-- Butonul de adăugare -->
                            <button
                                class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-normal text-xs py-2 px-6 rounded-full"
                                onclick="showAddForm()">Adaugă produs</button>

                            <!-- Formularul de adăugare produs-->
                            <div id="add-form" class="hidden">
                                <form action="include/adauga_produs.inc.php" method="POST" class="mt-4">
                                    <label class="block text-gray-500 text-sm">Nume produs:</label>
                                    <input type="text" name="nume_produs" class="border rounded py-2 px-4 mb-2 w-full">
                                    <button type="submit"
                                        class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-normal text-xs py-2 px-6 rounded-full">Adaugă</button>
                                </form>
                            </div>

                        </div>

                    </div>
                    <br>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
function showAddForm() {
    // Ascunde butonul de adăugare și afișează formularul de adăugare
    document.getElementById('add-form').classList.remove('hidden');
}
</script>

<?php require('partials/footer.php') ?>