<?php session_start(); ?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg ">
            <div class=" flex flex-col justify-center h-48 mb-4 rounded bg-indigo-50">
                <div class="text-center" >
                    <p class="text-2xl text-slate-600 ">Deschidere Depozit la termen</p>
                    <p class="mt-4 px-16 text-xl text-slate-500 ">Deschide-ti acum online un Depozit la
                        termen, ca sa te bucuri mai tarziu de banii tai. Depui o suma si vezi cum creste in timp. Tu
                        alegi perioada de timp in care vrei sa economisesti, fie ca e vorba de 1 luna, 6 luni, sau 12 de
                        luni.</p>
                    <button class="showmodal bg-violet-300 hover:bg-violet-700 px-3 py-1 rounded-xl text-white m-5">Depozit
                        Nou</button>
                </div>
                <form action="includes/procesare_formular_depozit.inc.php" method="POST">
                    <div
                        class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
                        <!-- modal -->

                        <div class="bg-white rounded shadow-lg w-1/3">
                            <!-- modal header -->
                            <div class="border-b px-4 py-2 flex justify-between items-center">
                                <h3 class="font-semibold text-lg">Depozit Nou</h3>
                                <button class="text-black closemodal">&cross;</button>
                            </div>
                            <!-- modal body -->
                            <div class="p-3">
                                <div class="flex flex-row items-center">

                                    <input type="hidden" name="id_client" value="<?php echo $_SESSION['id_client']; ?>">

                                </div>
                                <div class="flex flex-row items-center">
                                    <label for="nume_depozit"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2">Nume:
                                    </label>
                                    <input type="text" name="nume_depozit" id="nume_depozit"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                </div>
                                <div class="flex flex-row items-center">
                                    <label for="suma_depusa"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2">Suma:</label>
                                    <input type="text" name="suma_depusa" id="suma_depusa"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                </div>
                                <div class="flex flex-row items-center mt-2">
                                    <label for="perioada_depozit"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2 ">Perioada:</label>
                                    <select name="perioada_depozit" id="perioada_depozit" onchange="updateDobanda()">
                                        <option value="1">1 luna</option>
                                        <option value="3">3 luni</option>
                                        <option value="6">6 luni</option>
                                        <option value="9">9 luni</option>
                                        <option value="12">12 luni</option>
                                    </select>

                                </div>
                                <div class="flex flex-row items-center mt-2">
                                    <label for="data_depunere"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2 ">Data
                                        depunere:</label>
                                    <input type="date" name="data_depunere" value="<?php echo date('Y-m-d'); ?>"
                                        required>
                                </div>
                                <div class="flex flex-row items-center mt-2">
                                    <label for="data_expirare"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2">
                                        Data expirare:</label>
                                    <input id="data_expirare" type="date" name="data_expirare" required>
                                </div>


                                <!-- <div class="flex flex-row items-center">
                                <label for="perioada_depozit"
                                    class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2">Perioada</label>

                                <select id="mySelect" onchange="updateInput()">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>

                                <input id="myInput" type="text">


                            </div> -->
                                <div class="flex flex-row items-center mt-2">
                                    <label for="rata_depozit"
                                        class="peer-focus:font-medium text-sm text-gray-500 dark:text-gray-400 px-2 ">
                                        Rata dobanda:</label>

                                    <input type="text" name="rata_dobanda" id="rata_dobanda" placeholder=" " required
                                        readonly>
                                </div>
                            </div>
                            <div class="flex justify-end items-center w-100 border-t p-3">
                                <button
                                    class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 closemodal">Cancel</button>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white">Trimite</button>
                            </div>
                        </div>
                </form>
            </div>
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



function updateInput() {
    var selectValue = document.getElementById("mySelect").value;
    document.getElementById("myInput").value = selectValue;
};

function updateDobanda() {
    var select = document.getElementById("perioada_depozit");
    var rataDobanda = document.getElementById("rata_dobanda");
    var valoareSelectata = select.value;

    switch (valoareSelectata) {
        case "1":
            rataDobanda.value = "0.4";
            break;
        case "3":
            rataDobanda.value = "0.4";
            break;
        case "6":
            rataDobanda.value = "0.6";
            break;
        case "9":
            rataDobanda.value = "0.6";
            break;
        case "12":
            rataDobanda.value = "0.8";
            break;
        default:
            rataDobanda.value = "0.4";
    }
};

// Setează inițial data de expirare la data curentă
var dataDepunere = new Date().toISOString().slice(0, 10);
document.getElementById("data_expirare").value = dataDepunere;


function updateDataExpirare() {
    var perioada = document.getElementById("perioada_depozit").value;
    var dataExpirare = new Date(dataDepunere);

    // Adaugă luni la data de expirare în funcție de perioada selectată
    switch (perioada) {
        case "1":
            dataExpirare.setMonth(dataExpirare.getMonth() + 1);
            document.getElementById("rata_dobanda").value = "0.4";
            break;
        case "3":
            dataExpirare.setMonth(dataExpirare.getMonth() + 3);
            document.getElementById("rata_dobanda").value = "0.4";
            break;
        case "9":
            dataExpirare.setMonth(dataExpirare.getMonth() + 9);
            document.getElementById("rata_dobanda").value = "0.6";
            break;
        case "12":
            dataExpirare.setMonth(dataExpirare.getMonth() + 12);
            document.getElementById("rata_dobanda").value = "0.8";
            break;
        default:
            // Perioada implicită este de 1 lună
            dataExpirare.setMonth(dataExpirare.getMonth() + 1);
            document.getElementById("rata_dobanda").value = "0.4";
    }

    document.getElementById("data_expirare").value = dataExpirare.toISOString().slice(0, 10);
}


// Adaugă evenimentul onchange pe select
document.getElementById("perioada_depozit").onchange = function() {
    updateDataExpirare();
    dataDepunere = document.getElementById("data_expirare").value; // Actualizează dataDepunere cu noua valoare
};

// Adaugă evenimentul onchange pe select
document.getElementById("perioada_depozit").onchange = updateDataExpirare;
</script>

<?php require('partials/footer.php') ?>