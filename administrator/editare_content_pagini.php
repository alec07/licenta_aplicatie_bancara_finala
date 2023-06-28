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
                <h2 class="text-4xl">Formular de editare pentru paginile aplicației web</h2>
                <div class="">
                    <div class="">
                    <?php
include_once 'include/db.inc.php';
// Verificați dacă s-a transmis ID-ul pagini_continut prin URL
if (isset($_GET["id_pagina"])) {
    // Preia ID-ul pagini_continut din tabela "pagini_continut"
    $id_pagina = $_GET["id_pagina"];
}

if ($id_pagina) {
    // Tabelele în care se va căuta și se va actualiza
    $related_tables = ['index_page', 'despreapp_page', 'istoric_page'];

    echo "<form method='POST' action='include/editare_pagini_continut.php'>";

    foreach ($related_tables as $table_name) {
        $select_query = "SELECT h1_text, h2_text FROM $table_name WHERE id_pagina = ?";
        $stmt = $conn->prepare($select_query);
        $stmt->bind_param("s", $id_pagina);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificați dacă există înregistrări în rezultat
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<label for='h1_text'>H1 Text:</label>";
            echo "<input type='text' name='h1_text' value='".$row['h1_text']."' class='border border-gray-300 rounded p-2 mb-2 w-full'><br><br>";

            echo "<label for='h2_text'>H2 Text:</label>";
echo "<textarea name='h2_text' class='border border-gray-300 rounded p-2 mb-2 w-full'>".$row['h2_text']."</textarea><br><br>";

        }
    }

    echo "<input type='hidden' name='id_pagina' value='$id_pagina'>";
    echo "<button type='submit' name='salveaza' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Salvează</button>";
    echo "</form>";
}
?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>