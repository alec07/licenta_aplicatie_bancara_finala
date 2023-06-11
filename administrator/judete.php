<?php
    include_once 'include/db.inc.php';
?>
<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>

<?php
// Verificăm dacă există un mesaj de afișat
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<p>".$msg."</p>";
}
?>
<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
                    <h1>ORASE</h1>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    nume oras
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    id_oras
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

                                // selectare date din tabel
                                $sql=" SELECT * FROM orase  ";
                                $result = $conn->query($sql);
                                // afișare date în tabel
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr class='bg-white  '><td class='px-6 py-2'>" . $row["nume_oras"]  . "</td><td>" . $row["id_oras"]. "</td><td><a href='judete.php?id_oras=" . $row["id_oras"] . "'>Edit</a></td><td><a onclick='return confirm(\"Sigur doriți să ștergeți acest client?\")' href='include/sterge_orase.php?id_oras=" . $row["id_oras"] . "'>Sterge</a></td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Nu sunt adaugate judete/orase</td></tr>";
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
                                $id_oras = $_POST["id_oras"];
                                $nume_oras = $_POST["nume_oras"];

                                // actualizează datele în baza de date
                                $sql = "UPDATE orase SET nume_oras='$nume_oras' WHERE id_oras='$id_oras'";
                                if (mysqli_query($conn, $sql)) {
                                        echo "Date actualizate cu succes";
                                        echo "<script>setTimeout(function(){window.location.href='judete.php'},1000);</script>";
                                        }
                                    else {
                                        echo "Eroare la actualizarea datelor: " . mysqli_error($conn);
                                    }
                                }

                                // afișare formular pentru editare
                                if (isset($_GET["id_oras"])) {
                                    $id_oras = $_GET["id_oras"];

                                    // preia datele orasului din baza de date
                                    $sql = "SELECT id_oras , nume_oras FROM orase WHERE id_oras='$id_oras'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);

                                    // afișare formular pentru editare
                                    echo "<h2>Editare Oras</h2>";
                                    echo "<form method='post'>";
                                    echo "<input type='hidden' name='id_oras' value='" . $row["id_oras"] . "'>";
                                    echo "nume_oras: <input type='text' name='nume_oras' value='" . $row["nume_oras"] . "'>";
                                    echo "<br><br>";
                                    echo "<input type='submit' name='edit' value='Salveaza'>";
                                    echo "</form>";
                                }
                            ?>
                        <br></br>

                        <!-- Butonul de adăugare -->
                        <button
                            class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-normal text-xs py-2 px-6 rounded-full"
                            onclick="showAddForm()">Adaugă oras</button>

                        <!-- Formularul de adăugare utilizator -->
                        <div id="add-form" class="hidden">
                            <form action="include/adauga_oras.inc.php" method="POST" class="mt-4">
                                <label class="block text-gray-500 text-sm">Nume oras:</label>
                                <input type="text" name="nume_oras" class=" rounded py-2 px-4 mb-2 w-full">
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

<script>
function showAddForm() {
    // Ascunde butonul de adăugare și afișează formularul de adăugare
    document.getElementById('add-form').classList.remove('hidden');
}
</script>

<?php require('partials/footer.php') ?>