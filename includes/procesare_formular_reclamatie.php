<?php
// Verificați dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preiați datele formularului
    $subiect_reclamatie = $_POST['subiect_reclamatie'];
    $nume_reclamant = $_POST['nume_reclamant'];
    $prenume_reclamant = $_POST['prenume_reclamant'];
    $nr_telefon = $_POST['nr_telefon'];
    $mesaj_reclamatie = $_POST['mesaj_reclamatie'];
    include('db.inc.php');
    // Verificați conexiunea la baza de date
    if (!$conn) {
        die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
    } else {
        // Construiți și executați interogarea SQL pentru inserarea utilizatorului
        $sql = "INSERT INTO formular_reclamatii (subiect_reclamatie, nume_reclamant, prenume_reclamant, nr_telefon, mesaj_reclamatie) VALUES ('$subiect_reclamatie', '$nume_reclamant', '$prenume_reclamant', '$nr_telefon', '$mesaj_reclamatie')";

        if (mysqli_query($conn, $sql)) {
            $msg = "Formularul a fost trimis cu succes!";
            header("Location: ../form_reclamatie.php?msg=" . urlencode($msg));
            exit(); // Adăugați această linie pentru a opri execuția scriptului după redirecționare
        } else {
            echo "Eroare la trimiterea formularului: " . mysqli_error($conn);
        }
    }
}
?>
