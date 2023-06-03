<?php
    require_once('include/db.inc.php');

?>

<?php require('partials/head.php') ?>
<?php
//Verificăm dacă există un mesaj de afișat
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<p>".$msg."</p>";
}
?>



<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">

    <!-- nav -->
    <div class="absolute top-0 left-0 w-full">
        <div class="w-full max-w-6xl mx-auto px-4">
            <div class="w-full flex items-center justify-between py-5">
                <div class="flex-1 flex items-center">
                    <a href="utilizatori.php">CeloBank</a>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-end">
                        <a href="utilizatori.php"><button type="">x</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class=" w-full pt-20  align-center justify-center">
        <div class="w-full max-w-6xl mx-auto ">
            <div class="text-center">
                <h2 class="text-4xl">Formular editare date client</h2>
                <div class="">
                    <div class="">
                        <!-- Formularul de editare -->
                        <?php $id_client = $_GET['id_client']; // preia ID-ul clientului din URL sau din altă sursă
                            $sql = "SELECT * FROM inregistrare_client WHERE id_client = $id_client";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            } else {
                            echo "Eroare la obținerea datelor: " . mysqli_error($conn);
                            }
                            ?>
                        <div class="mt-10 ">
                            <form action="include/edit.inc.php" method="post">
                                <input value="<?php echo $id_client; ?>" type="hidden" name="id_client">
                                <input value="<?php echo $row['cnp']; ?>" type="text" id="cnp" name="cnp"
                                    class="pointer-events-none mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]"  readonly/>

                                    <input value="<?php echo $row['nume']; ?>" type="text" id="nume" name="nume"
                                    class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" />

                                    <input value="<?php echo $row['prenume']; ?>" type="text" id="prenume" name="prenume"
                                    class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" />

                                    <input value="<?php echo $row['email']; ?>" type="text" id="email" name="email"
                                    class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" />

                                    <input value="<?php echo $row['adresa']; ?>" type="text" id="adresa" name="adresa"
                                    class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" />




                                    <input value="<?php echo $row['numar_card']; ?>" type="text" id="numar_card" name="numar_card"
                                    class="pointer-events-none mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" readonly/>

                                    <input value="<?php echo $row['cvv']; ?>" type="text" id="cvv" name="cvv"
                                    class="pointer-events-none mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" readonly/>

                                    <input value="<?php echo $row['iban']; ?>" type="text" id="iban" name="iban"
                                    class="pointer-events-none mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" readonly/>
                                <button class="mb-5 px-8 py-2 rounded-lg bg-violet-500 text-white" type="submit">Salvează</button>
                                <button class=" mb-5 px-8 py-2 rounded-lg bg-violet-500 text-white" type="button">Anulează</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<?php require('partials/footer.php') ?>