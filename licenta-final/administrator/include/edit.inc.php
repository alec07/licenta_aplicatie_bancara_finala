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
    $id_client = $_POST['id_client'];
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    // Actualizarea datelor in baza de date
    $sql = "UPDATE inregistrare_client SET nume='$nume', prenume='$prenume', email='$email', telefon='$telefon' WHERE id_client=$id_client";

    if ($conn->query($sql) === TRUE) {
        $msg = "Datele au fost actualizate cu succes!";
        header("Location: ../utilizatori.php?msg=".urlencode($msg));
        exit();
    } else {
        echo "Eroare: " . $conn->error;
    }

    // Inchidem conexiunea la baza de date
    $conn->close();
}
?>
