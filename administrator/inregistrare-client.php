<?php include ('include/db.inc.php');?>
<?php include('partials/head.php'); ?>
<?php include ('partials/sidebar.php'); ?>


<main>
    <div class=" py-4 sm:ml-60">
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full items-center justify-left  px-4 sm:px-6 lg:px-8">
                <div class="w-full ">
                    <div>
                        <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900">Inregistrare client nou
                        </h2>
                    </div>
                    <form class="mt-8 space-y-6" action="include/inregistrare-client.inc.php" method="POST">
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="cnp">CNP</label>
                                <input name="cnp" id="cnp" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyCNP'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                            <div>
                                <label class="text-black" for="nume">Nume</label>
                                <input name="nume" id="nume" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Nume familie</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyNUME'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                            <div>
                                <label class="text-white" for="initiala_t"> f</label>
                                <input name="initiala_t" id="initiala_t" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Initiala tata</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyINITIALA_T'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                            <div>
                                <label class="text-white" for="prenume"> f</label>
                                <input id="prenume" type="text" name="prenume"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Prenume</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyPRENUME'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                            <div>
                                <label class="text-black" for="emailAddress">Email Address</label>
                                <input name="email" id="emailAddress" type="email"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyEMAIL'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>

                            <?php if(isset($errors['email'])): ?>
                            <p class="text-red-500 text-xs mt-2"><?=$errors['email']?></p>
                            <?php endif; ?>

                            <div>
                                <label class="text-black" for="telefon">Telefon</label>
                                <input name="telefon" id="telefon" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyTELEFON'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>

                        </div>


                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="adresa">Adresa</label>
                                <input name="adresa" id="adresa" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Adresa1</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyADRESA'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="text-white" for="orase"></label>
                                <?php
$query = "SELECT id_oras, nume_oras FROM orase";
$result = mysqli_query($conn, $query);
echo '<select name="orase" id="orase" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">';

// Adaugare opțiuni
while ($row = mysqli_fetch_assoc($result)) {
    echo '<option value="' . $row['id_oras'] . '">' . $row['nume_oras'] . '</option>';
}

// Închidere lista dropdown
echo '</select>';

 ?>
                                <!-- <input name="oras" id="oras" type="option"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"> -->
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Oras</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyORAS'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                            <div>
                                <label class="text-white" for="tara"></label>
                                <input name="tara" id="tara" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">Tara</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyTARA'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div>
                            <label class=" text-green" for="data_nastere">Data nasterii</label>
                            <input name="data_nastere" id="data_nastere" type="date"
                                class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyDATA_NASTERE'){
                                        ?>
                            <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                trimiterea din nou.
                            </div>
                            <?php
                                    }
                                    ?>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-1 ">
                            <div>
                                <label class="text-black" for="proprietate">Proprietatea asupra locuintei</label>
                                <input name="proprietate" id="proprietate" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">
                                    detinua/inchiriata/locuinta
                                    parinti</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyPROPRIETATE'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1 ">
                            <div>
                                <label class="text-black" for="ocupatie">Ocupatie</label>
                                <input name="ocupatie" id="ocupatie" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <p class=" text-xs font-light text-gray-500 dark:text-gray-40">
                                    student/elev/lucrator/liber
                                    profesionist</p>
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyOCUPATIE'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1 ">
                            <div>
                            <label class="text-black" for="gen">Gen</label>
                                <input name="gen" id="gen" type="radio"
                                    class="form-radio" value="M">
                                    <span class="ml-2">M</span>
                                <input name="gen" id="gen" type="radio"
                                    class="form-radio" value="F">
                                    <span class="ml-2">F</span>
                                <input name="gen" id="gen" type="radio"
                                    class="form-radio" value="N">
                                    <span class="ml-2">N</s
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyGEN'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="suma_depusa">Suma depusa</label>
                                <input name="suma_depusa" id="suma_depusa" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptySUMA_DEPUSA'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="numar_card">Numar card</label>
                                <input name="numar_card" id="numar_card" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="<?php
                                    $nrcard = str_pad(rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
                                    echo $nrcard;
                                ?>">

                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyNUMAR_CARD'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="iban">IBAN</label>
                                <input name="iban" id="iban" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="<?php  $countryCode = "RO";
                                        $bankCode = "CELO";
                                        $accountNumber = str_pad(rand(0, 999999999999999999), 18, '0', STR_PAD_LEFT);
                                        $iban = $countryCode . $bankCode . $accountNumber;
                                        echo $iban; ?> ">


                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyIBAN'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="cvv">CVV</label>
                                <input name="cvv" id="cvv" type="text"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="<?php
                                    $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                                    echo $randomNumber;
                                ?>">


                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyCVV'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="data_expirare">Data expirarii</label>
                                <input name="data_expirare" id="data_expirare" type="date"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyDATA_EXPIRARE'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="data_deschidere">Data deschidere cont</label>
                                <input name="data_deschidere" id="data_deschidere" type="date"
                                    value="<?php echo date('Y-m-d'); ?>"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyDATA_DESCHIDERE'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <label class="text-black" for="parola">Parola</label>
                                <input name="parola" id="parola" type="password"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md  focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                <?php
                                    if(isset($_GET['error']) && $_GET['error']=='emptyPAROLA'){
                                        ?>
                                <div class="p-4 mt-2 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">Neconform!</span> Schimbați câteva lucruri și încercați
                                    trimiterea din nou.
                                </div>
                                <?php
                                    }
                                    ?>

                            </div>
                        </div>
                        <?php if(isset($errors['password'])): ?>
                        <p class="text-red-500 text-xs mt-2"><?=$errors['password']?></p>
                        <?php endif; ?>


                        <div class="grid grid-cols-1 gap-6 mt-3 sm:grid-cols-1">
                            <div>
                                <button type="submit" name="submit"
                                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    Inregistrare
                                </button>
                            </div>


                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>




    </div>
</main>

<?php require('partials/footer.php') ?>