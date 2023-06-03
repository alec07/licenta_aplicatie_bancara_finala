<?php
// Verificați dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preiați datele formularului
    $nume_produs = $_POST['nume_produs'];

include_once 'db.inc.php';

    // Verificați conexiunea la baza de date
    if (!$conn) {
        die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
    }

    // Construiți și executați interogarea SQL pentru inserarea utilizatorului
    $sql = "INSERT INTO produse_bancare (nume_produs) VALUES ('$nume_produs')";
    if (mysqli_query($conn, $sql)) {
        $msg = "produsul a fost adaugat cu succes!";
        header("Location: ../produse.php?msg=".urlencode($msg));
    } else {
        echo "Eroare la adăugarea produsului: " . mysqli_error($conn);
    }


}
?>