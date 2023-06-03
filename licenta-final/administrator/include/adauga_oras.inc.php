
<?php
// Verificați dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preiați datele formularului
    $nume_oras = $_POST['nume_oras'];

include_once 'db.inc.php';

    // Verificați conexiunea la baza de date
    if (!$conn) {
        die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
    }

    // Construiți și executați interogarea SQL pentru inserarea utilizatorului
    $sql = "INSERT INTO orase (nume_oras) VALUES ('$nume_oras')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Orasul a fost adaugat cu succes!";
        header("Location: ../judete.php?msg=".urlencode($msg));
    } else {
        echo "Eroare la adăugarea orasului: " . mysqli_error($conn);
    }


}
?>