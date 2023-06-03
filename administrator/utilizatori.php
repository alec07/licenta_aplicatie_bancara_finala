<?php
    require_once('include/db.inc.php');
    $sql=" SELECT * FROM inregistrare_client WHERE user_type = 'user' ";
    $result = $conn->query($sql);
?>

<?php require('partials/head.php') ?>
<?php include ('partials/sidebar.php'); ?>
<?php
//Verificăm dacă există un mesaj de afișat
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<p>".$msg."</p>";
}
?>

<?php
// Conexiunea la baza de date și interogarea inițială

// Verificăm dacă există cererea POST pentru filtrare
if (isset($_POST['filtrare'])) {
    $dataInceput = $_POST['dataInceput'];
    $dataSfarsit = $_POST['dataSfarsit'];

    // Realizați interogarea bazei de date pentru a filtra în funcție de perioadă
    $query = "SELECT * FROM inregistrare_client WHERE (data_nastere BETWEEN '$dataInceput' AND '$dataSfarsit') OR (data_deschidere BETWEEN '$dataInceput' AND '$dataSfarsit')";
    $result = mysqli_query($conn, $query);
} else {
    // Dacă nu există o cerere de filtrare, afișăm toate înregistrările
    $query = "SELECT * FROM inregistrare_client";
    $result = mysqli_query($conn, $query);
}
?>

<!-- ... -->


<div class="py-4 sm:ml-60">
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="flex min-h-full  px-4 sm:px-6 lg:px-8">
            <div class="w-full ">
                <div class=" text-sm text-center mb-12 ">
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Utilizatori</h1>
                    <div class="flex justify-between">
                        <button onclick="deschideDreptunghi()" type="button"
                            class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Adauga
                            filtru</button>
                            <button  type="button"
                            class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 "><a href="include/exporta_utilizatori.inc.php"> Exporta</a></button>
                    </div>


                    <!-- Adăugați formularul pentru filtrare în partea de sus a tabelului -->

                    <form method="POST" class="mb-4">
                        <div class="flex items-center mb-2">
                            <label for="dataInceput" class="mr-2">Data început:</label>
                            <input type="date" id="dataInceput" name="dataInceput"
                                class="border border-gray-300 rounded px-3 py-2">
                        </div>
                        <div class="flex items-center">
                            <label for="dataSfarsit" class="mr-2">Data sfârșit:</label>
                            <input type="date" id="dataSfarsit" name="dataSfarsit"
                                class="border border-gray-300 rounded px-3 py-2">
                        </div>
                        <button type="submit" name="filtrare"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Filtrează</button>
                    </form>

                    <!-- Afișați tabelul cu rezultatele filtrate sau toate înregistrările -->
                    <table class="w-full text-sm text-center text-gray-500">
                        <!-- ... -->
                        <tbody>
                            <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Afișați înregistrările în tabel
                $id_oras = $row['oras'];
                // Realizam o interogare suplimentară pentru a obține numele orașului bazat pe ID-ul orașului
                $query_oras = "SELECT nume_oras FROM orase WHERE id_oras = $id_oras";
                $result_oras = mysqli_query($conn, $query_oras);
                $oras = mysqli_fetch_assoc($result_oras)['nume_oras'];
                ?>
                            <tr>
                                <td class=" px-4 py-2"><?php echo $row['id_client']; ?></td>
                                <td class=" px-4 py-2"><?php echo $row['nume']; ?></td>
                                <td class=" px-4 py-2"><?php echo $row['initiala_t']; ?></td>
                                <td class=" px-4 py-2"><?php echo $row['prenume']; ?></td>
                                <td class=" px-4 py-2"><?php echo $row['data_nastere']; ?></td>
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
                                <td class="">
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

        <?php require('partials/footer.php') ?>