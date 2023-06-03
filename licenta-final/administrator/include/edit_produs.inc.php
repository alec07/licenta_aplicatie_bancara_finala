<?php
// Verificăm dacă formularul a fost trimis
if(isset($_POST['submit'])){

    // Conectarea la baza de date
    require_once('db.inc.php');


    // Verificăm conexiunea la baza de date
    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    // Prelucrarea datelor din formular
    $id_produs = $_POST['id_produs'];
    $nume_produs = $_POST['nume_produs'];


    // Actualizarea datelor in baza de date
    $sql = "UPDATE  produse_bancare  SET nume_produs='$nume_produs' WHERE id_produs='$id_produs'";

    if ($conn->query($sql) === TRUE) {
        $msg = "Datele au fost actualizate cu succes!";
        header("Location: ../produse.php?msg=".urlencode($msg));
        exit();
    } else {
        echo "Eroare: " . $conn->error;
    }

    // Inchidem conexiunea la baza de date
    $conn->close();
}
?>
