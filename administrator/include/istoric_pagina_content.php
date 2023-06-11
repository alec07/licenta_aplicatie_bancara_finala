<?php
include_once 'db.inc.php';
// Preiați id_pagina din URL sau formular
$id_pagina = $_GET['id_pagina'];

// Interogare pentru a obține istoricul paginii
$query_istoric = "SELECT * FROM istoric_editari_indexpage WHERE id_pagina = ?";
$stmt_istoric = $conn->prepare($query_istoric);
$stmt_istoric->bind_param("i", $id_pagina);
$stmt_istoric->execute();
$result_istoric = $stmt_istoric->get_result();

// Afișați istoricul paginii
if (mysqli_num_rows($result_istoric) > 0) {
    while ($row = mysqli_fetch_assoc($result_istoric)) {
        echo "<tr>";
        echo "<td>" . $row["data_editare"] . "</td>";
        echo "<td>" . $row["h1_text"] . "</td>";
        // Afișați alte informații relevante despre istoricul paginii
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>Nu există istoric pentru această pagină</td></tr>";
}



?>