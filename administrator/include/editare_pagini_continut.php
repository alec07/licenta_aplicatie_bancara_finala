<?php
include_once 'db.inc.php';
// Verificați dacă a fost trimis formularul de editare
if (isset($_POST['salveaza'])) {
    $update_params = array();

    // Iterați prin valorile primite din formular
    foreach ($_POST as $key => $value) {
        if ($key !== 'id_pagina') {
            // Descompuneți cheia pentru a obține numele tabelului și numele coloanei
            $parts = explode('.', $key);
            if (count($parts) === 2) {
                $table_name = $parts[0];
                $column_name = $parts[1];
                if (!empty($value)) {
                    $update_params[] = "$table_name.$column_name = ?";
                }
            }
        }
    }

    // Verificați dacă există date de actualizat
    if (!empty($update_params)) {
        $set_clause = implode(', ', $update_params);
        $update_query = "UPDATE pagini_continut
                         LEFT JOIN $related_tables[0] ON pagini_continut.id_pagina = $related_tables[0].id_pagina
                         SET $set_clause
                         WHERE pagini_continut.id_pagina = ?";

        $stmt_update = $conn->prepare($update_query);

        // Construiți șirul de definiție a tipului pentru bind_param
        $bind_types = str_repeat('s', count($update_params) + 1);

        // Construiți lista de valori pentru bind_param
        $bind_values = [];
        foreach ($update_params as $value) {
            $bind_values[] = $value;
        }
        $bind_values[] = $id_pagina;

        // Legați parametrii și executați interogarea
        $stmt_update->bind_param($bind_types, ...$bind_values);
        $stmt_update->execute();

        // Verificați rezultatul actualizării
        if ($stmt_update->affected_rows > 0) {
            echo "Datele au fost actualizate cu succes!";
        } else {
            echo "Nu s-au putut actualiza datele.";
        }
    } else {
        echo "Nu există date de actualizat!";
    }
}

?>
