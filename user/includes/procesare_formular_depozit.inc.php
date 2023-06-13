<?php
session_start();
include('db.inc.php');

$id_client = $_POST['id_client']; // presupunem că id-ul clientului a fost trimis în formular
$data_depunere = $_POST['data_depunere'];
$data_expirare = $_POST['data_expirare'];
$rata_dobanda = $_POST['rata_dobanda'];
$suma_depusa = $_POST['suma_depusa'];
$nume_depozit = $_POST['nume_depozit'];
$perioada_depozit = $_POST['perioada_depozit'];

$query = "SELECT id_client FROM conturi WHERE id_client = $id_client";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_client = $row['id_client'];

    $query = "INSERT INTO depozite (id_client, data_depunere, data_expirare, rata_dobanda, suma_depusa, nume_depozit, perioada_depozit) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Asigură-te că $stmt este un obiect de tip mysqli_stmt
    if ($stmt === false) {
        die("Eroare la pregătirea instrucțiunii SQL: " . mysqli_error($conn));
    }

    // Asociază valorile cu parametrii instrucțiunii SQL pregătite
    mysqli_stmt_bind_param($stmt, "issssss", $id_client, $data_depunere, $data_expirare, $rata_dobanda, $suma_depusa, $nume_depozit, $perioada_depozit);

    // Execută instrucțiunea pregătită
    if (mysqli_stmt_execute($stmt)) {
        $id_depozit = mysqli_insert_id($conn); // Obțineți ID-ul depozitului inserat

    // Obțineți suma curentă din contul clientului
    $query = "SELECT suma_depusa FROM conturi WHERE id_client = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_client);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $suma_cont);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Scădeți suma depusă în depozit din suma curentă a contului clientului
    $suma_cont -= $suma_depusa;

    // Actualizați valoarea sumei în baza de date pentru contul clientului
    $query = "UPDATE conturi SET suma_depusa = ? WHERE id_client = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "di", $suma_cont, $id_client);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
        $msg = "Depozitul a fost înregistrat cu succes";
        header("Location: ../produse.php?msg=".urlencode($msg));
    } else {
        echo "Eroare la înregistrarea depozitului: " . mysqli_error($conn);
    }

    // Închide instrucțiunea pregătită
    mysqli_stmt_close($stmt);
} else {
    echo "Eroare: ID-ul clientului nu a fost găsit în tabela conturi.";
}

// Închide conexiunea la baza de date
mysqli_close($conn);
?>