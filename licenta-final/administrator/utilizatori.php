<?php
    require_once('include/db.inc.php');
    $sql=" SELECT * FROM inregistrare_client WHERE user_type = 'user' ";
    $result = $conn->query($sql);
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
                    <h1 class="text-3xl text-slate-800 justify-left flex mb-4">Utilizatori</h1>
                    <div class="flex justify-between">
                        <button type="button"
                            class=" text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Adauga
                            filtru</button>
                        <button type="button"
                            class=" justify-right text-slate-600 bg-slate-100  focus:outline-none hover:bg-slate-200 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-xs px-5 py-2  mb-2 ">Exporta</button>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead>
                                <tr>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Id</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Nume</th>
                                    <th class="text-slate-500 text-sm font-medium px-2 py-2">Initiala Tata</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Prenume</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Data Nastere</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Oras</th>
                                    <th class="text-slate-500 text-sm font-medium px-4 py-2">Ocupatie</th>
                                    <th class="text-slate-500 text-sm font-medium px-2 py-2">Editare</th>
                                    <th class="text-slate-500 text-sm font-medium px-2 py-2">Stergere</th>
                                    <!-- adaugam o coloana pentru butoanele de actiune -->
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <?php
                        if($result->num_rows>0 ){
                            while($row=$result->fetch_assoc()){  $id_oras = $row['oras'];
                            // Realizați o interogare suplimentară pentru a obține numele orașului bazat pe ID-ul orașului
                                $query_oras = "SELECT nume_oras FROM orase WHERE id_oras = $id_oras";
                                $result_oras = mysqli_query($conn, $query_oras);
                                $oras = mysqli_fetch_assoc($result_oras)['nume_oras'];
                                ?>
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

                                    <td class=" px-4 py-2"><?php echo $row['ocupatie']; ?></td>
                                    <td class="">
                                        <button data-id="<?php echo $row['id_client']; ?>"
                                            class="border-none showmodal  hover:bg-violet-50 px-3 py-1 rounded text-indigo-500 m-5"
                                            type="">
                                            Edit
                                        </button>
                                    </td>

                                    <form action="include/edit.inc.php" method="POST">
                                        <div
                                            class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
                                            <!-- modal -->

                                            <div class="bg-white rounded shadow-lg w-1/3">
                                                <!-- modal titlu -->
                                                <div class="border-b px-4 py-2 flex justify-between items-center">
                                                    <h3 class="font-semibold text-lg">Editeaza Datele Clientului</h3>
                                                    <button class="text-black closemodal">&cross;</button>
                                                </div>
                                                <!-- modal body -->
                                                <div class="p-3">
                                                    <input type="hidden" name="id_client"
                                                        value="<?php echo $row['id_client']; ?>">

                                                    <label for="nume">Nume:</label>
                                                    <input type="text" name="nume" id="nume"
                                                        value="<?php echo $row['nume']; ?>"><br><br>

                                                    <label for="prenume">Prenume:</label>
                                                    <input type="text" name="prenume" id="prenume"
                                                        value="<?php echo $row['prenume']; ?>"><br><br>

                                                    <label for="email">Email:</label>
                                                    <input type="email" name="email" id="email"
                                                        value="<?php echo $row['email']; ?>"><br><br>

                                                    <label for="telefon">Telefon:</label>
                                                    <input type="tel" name="telefon" id="telefon"
                                                        value="<?php echo $row['telefon']; ?>"><br><br>

                                                    <input type="submit" name="submit" value="Salveaza modificari">
                                                </div>

                                                <div class="flex justify-end items-center w-100 border-t p-3">
                                                    <button
                                                        class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 closemodal">Cancel</button>
                                                    <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">Trimite</button>

                                                </div>
                                    </form>
                                    <td class="">
                                        <form method="post" action="include/sterge_client.inc.php">
                                            <input type="hidden" name="id_client"
                                                value="<?php echo $row['id_client']; ?>">

                                            <button onclick="return confirm('Sigur doriți să ștergeți acest client?')"
                                                class="  hover:bg-red-50 px-3 py-1 rounded text-red-500 " name="delete"
                                                type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
            const modal = document.querySelector('.modal');
            const showmodal = document.querySelector('.showmodal');
            const closemodal = document.querySelectorAll('.closemodal');
            showmodal.addEventListener('click', function() {
                modal.classList.remove('hidden')
            });
            closemodal.forEach(close => {
                close.addEventListener('click', function() {
                    modal.classList.add('hidden')
                });
            });
            </script>

            <?php require('partials/footer.php') ?>