<?php
include_once 'db.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificăm dacă s-a transmis ID-ul pagini_continut prin formular
    if (isset($_POST["id_pagina"])) {
        $id_pagina = $_POST["id_pagina"];

        // Preluăm valorile din formular
        $h1_text = $_POST["h1_text"];
        $h2_text = $_POST["h2_text"];

        // Tabelele în care se va actualiza
        $related_tables = ['index_page', 'despreapp_page', 'istoric_page'];

        foreach ($related_tables as $table_name) {
            // Actualizăm valorile în fiecare tabel asociat
            $update_query = "UPDATE $table_name SET h1_text = ?, h2_text = ? WHERE id_pagina = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("sss", $h1_text, $h2_text, $id_pagina);
            $stmt->execute();
        }

        // Adăugăm înregistrarea în tabela istoric_editari
        $data_editare = date("Y-m-d H:i:s");
        $insert_query = "INSERT INTO istoric_editari_indexpage (id_pagina, h1_text, h2_text, data_editare) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $id_pagina, $h1_text, $h2_text, $data_editare);
        $stmt->execute();

        if ($stmt) {
            // Datele au fost actualizate cu succes
            // Redirecționați utilizatorul către o pagină de succes sau afișați un mesaj de confirmare
            $msg = "Pagina a fost modificata cu succes!";
            header("Location: ../content_pagini.php?msg=".urlencode($msg));

          } else {

            // Inchidem conexiunea la baza de date
            $conn->close();
          }
        }
}
?>
