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

$id_pagina = null;
// Verificați dacă s-a transmis ID-ul pagini_continut prin URL
if (isset($_GET["id_pagina"])) {
    // Preia ID-ul pagini_continut din tabela "pagini_continut"
    $id_pagina = $_GET["id_pagina"];
}

if ($id_pagina) {
    // Construiți lista de nume de tabele legate la cheia primară din tabela "pagini_continut"
    $query = "SELECT GROUP_CONCAT(table_name SEPARATOR ',') AS related_tables
              FROM information_schema.key_column_usage
              WHERE referenced_table_name = 'pagini_continut'
                AND referenced_column_name = 'id_pagina'
                AND table_schema = DATABASE()";

    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if ($row) {
        // Obțineți lista de nume de tabele separate
        $related_tables = explode(',', $row['related_tables']);

        // Remove "istoric_editari_indexpage" from the related tables
        $related_tables = array_diff($related_tables, ['istoric_editari_indexpage']);

        // Construiți partea de SELECT și JOIN pentru fiecare tabel legat
        $select_queries = [];
        $join_queries = [];
        $bind_types = '';
        $bind_params = [$id_pagina];

        foreach ($related_tables as $table_name) {
            $select_queries[] = "$table_name.*";
            $join_queries[] = "LEFT JOIN $table_name ON pagini_continut.id_pagina = $table_name.id_pagina";
            $bind_types .= 's';
        }

        $select_query = implode(', ', $select_queries);
        $join_query = implode(' ', $join_queries);

        $final_query = "SELECT $select_query
                        FROM pagini_continut
                        $join_query
                        WHERE pagini_continut.id_pagina = ?";

        // Preparați și executați interogarea pentru a obține rezultatul
$stmt = $conn->prepare($final_query);
$stmt->bind_param("s", $id_pagina);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Obțineți numele tabelelor asociate
    $related_tables = [];
    $columns = $result->fetch_fields();
    foreach ($columns as $column) {
        if ($column->table != 'pagini_continut') {
            $related_tables[] = $column->table;
        }
    }

            // Afișați formularul de editare cu valorile existente
            echo "<form action='include/editare_pagini_continut.php' method='POST'>";
            echo "<input type='hidden' name='id_pagina' value='" . $id_pagina . "'>";


// Remove "istoric_editari_indexpage" from the related tables
$related_tables = array_diff($related_tables, ['istoric_editari_indexpage']);

// Selectați conținutul paginii din fiecare tabel asociat
$at_least_one_row = false; // Flag pentru a verifica dacă există cel puțin un rând de date

foreach ($related_tables as $table_name) {
    // Excludem tabela "istoric_editari_indexpage"
    if ($table_name === 'istoric_editari_indexpage') {
        continue;
    }

    $query_select_content = "SELECT *
                             FROM $table_name
                             WHERE id_pagina = ?";
    $stmt_select_content = $conn->prepare($query_select_content);
    $stmt_select_content->bind_param("s", $id_pagina);
    $stmt_select_content->execute();
    $result_select_content = $stmt_select_content->get_result();
    $row_select_content = $result_select_content->fetch_assoc();

    if ($row_select_content) {
        // Afișați valorile din tabelul asociat
        foreach ($row_select_content as $column_name => $value) {
            // Convertiți numele coloanei într-un format mai citibil
            $formatted_column_name = str_replace('_', ' ', ucfirst($column_name));

            echo "<label for='$column_name'>$formatted_column_name:</label>";
            echo "<input type='text' name='$table_name.$column_name' value='$value' class='border border-gray-300 rounded p-2 mb-2 w-full'><br><br>";
        }

        $at_least_one_row = true; // Există cel puțin un rând de date
    }
}


// Verificați dacă există cel puțin un rând de date
if ($at_least_one_row) {
    echo "<button type='submit' name='salveaza' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Salvează</button>";
} else {
    echo "Nu există date de actualizat!";
}

        } else {
            echo "Pagina selectată nu există.";
        }
    } else {
        echo "Nu există tabele legate la cheia primară din tabela 'pagini_continut'.";
    }
}

?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>