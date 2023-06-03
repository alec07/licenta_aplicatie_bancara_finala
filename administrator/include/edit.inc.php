<?php
include 'db.inc.php';
// Verificăm dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluare și filtrare date din formular
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $adresa = $_POST['adresa'];
    $email = $_POST['email'];
    $oras = $_POST['oras'];
    $id_client = $_POST['id_client'];
    // Validați și actualizați datele în baza de date
$sql = "UPDATE inregistrare_client SET nume = '$nume', prenume = '$prenume', adresa='$adresa', email=' $email', oras=$oras WHERE id_client = $id_client";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Datele au fost actualizate cu succes
    // Redirecționați utilizatorul către o pagină de succes sau afișați un mesaj de confirmare
    $msg = "Datele clientului au fost modificate cu succes!";
    header("Location: ../utilizatori.php?msg=".urlencode($msg));

  } else {

    // Inchidem conexiunea la baza de date
    $conn->close();}
}
?>
