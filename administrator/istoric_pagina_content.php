<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="dialog.css" rel="stylesheet">
    <script src="jquery-3.6.4.min.js"></script>
    <script src="path/to/chartjs/dist/chart.umd.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>
    <title>Bank Page</title>
</head>
<body >
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
        echo "<h1 class='text-4xl mb-10'>Istoric pagină</h1>";
        echo "<table class='w-full text-sm text-left text-gray-500 '>";
        echo "<thead class='text-xs text-gray-700 uppercase bg-gray-50' ><tr><th scope='col; class='px-6 py-2'>Data Editare</th><th>Ttilul paginii</th><th>Conținutul text al paginii</th></tr></thead>";

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
</body>
</html>
