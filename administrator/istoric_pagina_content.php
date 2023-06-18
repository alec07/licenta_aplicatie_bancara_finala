<?php
include_once 'include/db.inc.php';

// Verificați dacă s-a transmis ID-ul pagini_continut prin URL
if (isset($_GET["id_pagina"])) {
    // Preia ID-ul pagini_continut din URL
    $id_pagina = $_GET["id_pagina"];

    // Interogare pentru a obține istoricul paginii
    $query = "SELECT * FROM istoric_editari_indexpage WHERE id_pagina = ? ORDER BY data_editare DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id_pagina);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificați dacă există înregistrări în rezultat
    if ($result->num_rows > 0) {
        echo "<h1>Istoric pagină</h1>";
        echo "<table>";
        echo "<tr><th>Data Editare</th><th>H1 Text</th><th>H2 Text</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $data_editare = $row['data_editare'];
            $h1_text = $row['h1_text'];
            $h2_text = $row['h2_text'];

            echo "<tr><td>$data_editare</td><td>$h1_text</td><td>$h2_text</td></tr>";
        }

        echo "</table>";
    } else {
        echo "Nu există înregistrări în istoricul paginii.";
    }
} else {
    echo "ID-ul pagini_continut lipsește!";
}
?>
