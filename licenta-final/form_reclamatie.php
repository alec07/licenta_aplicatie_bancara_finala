<?php include ('partials/header2.php'); ?>
<?php include ('partials/navbar2.php'); ?>


<div class="mt-20 max-w-4xl mx-auto">

    <a href="index.php" class="text-gray-300 font-bold">Home</a>
    <span class="text-gray-200 mx-2">/</span>
    <a href="form_reclamatie.php" class="text-gray-300">Reclamație</a>

    <!-- conținutul paginii -->
    <div class="mt-5 mb-5 font-serif">
        <h1 class="text-orange-200 font-serif text-4xl mb-10 text-left">Fă o plângere</h1>
        <form action="">
            <div class="mb-2">
                <!-- Câmpul de intrare (input) -->
                <input type="text" id="inputField" class="border-b border-gray-300 bg-orange-50 "
                    placeholder="Subiectul reclamației" onclick="toggleDropdown()">
                <!-- Meniul dropdown -->
                <ul id="dropdown" class="absolute hidden bg-white text-gray-800 p-2 mt-2 rounded-md">
                    <!-- Elementele meniului -->
                    <li onclick="selectOption('Depozite')">Depozite</li>
                    <li onclick="selectOption('Tranzacții')">Tranzacții</li>
                    <li onclick="selectOption('Altele')">Altele</li>
                </ul>
            </div>
            <div class="mb-2">
                <input type="text" class="border-b border-gray-300 bg-orange-50" placeholder="Nume">
            </div>
            <div class="mb-2">
                <input type="text" class="border-b border-gray-300 bg-orange-50" placeholder="Prenume">
            </div>
            <div class="mb-2">
                <input type="text" class="border-b border-gray-300 bg-orange-50" placeholder="Telefon">
            </div>
            <div class="mb-2">
                <textarea class=" border-b border-gray-300 w-96 h-20 bg-orange-50 rounded-xl " placeholder="Mesaj"></textarea>
            </div>
            <div class="mt-10">
                <p class="text-gray-400 text-sm">*Banca prelucrează datele cu caracter personal în scopul care rezultă
                    din interesele legitime urmărite de Bancă, adică în scopul depunerii de reclamații [articolul 6
                    alineatul (1) litera (f) din GDPR - Regulamentul (UE) 2016/679 al Parlamentului European și al
                    Consiliului din 27 aprilie 2016. privind protecția persoanelor fizice în ceea ce privește
                    prelucrarea datelor cu caracter personal și privind libera circulație a acestor date și de abrogare
                    a Directivei 95/46/CE], adică în scopul depunerii de reclamații.</p>
                <p class="text-gray-400 text-sm">*Această prelucrare este efectuată în special ca urmărire a
                    pretențiilor legate de reclamație și apărare împotriva pretențiilor împotriva Băncii în cadrul
                    reclamației acceptate.</p>
            </div>
            <button class="mt-10 text-white bg-orange-200 rounded-xl">Trimite formularul</button>

        </form>


    </div>
</div>


<?php include ('partials/bottom.php'); ?>
<?php include ('partials/footer.php'); ?>
<script>
function toggleDropdown() {
    var dropdown = document.getElementById("dropdown");
    dropdown.classList.toggle("hidden");
}

function selectOption(option) {
    var inputField = document.getElementById("inputField");
    inputField.value = option;

    var dropdown = document.getElementById("dropdown");
    dropdown.classList.add("hidden");
}
</script>