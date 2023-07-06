<?php
session_start();
include('db.inc.php');

$id_client = $_POST['id_client'];
$data_depunere = $_POST['data_depunere'];
$data_expirare = $_POST['data_expirare'];
$rata_dobanda = $_POST['rata_dobanda'];
$suma_depusa = $_POST['suma_depusa'];
$nume_depozit = $_POST['nume_depozit'];
$perioada_depozit = $_POST['perioada_depozit'];

$query = "SELECT id_client, suma_depusa FROM conturi WHERE id_client = $id_client";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_client = $row['id_client'];
    $suma_cont = $row['suma_depusa'];

    // Verifică dacă suma de depus este mai mare decât suma disponibilă în cont
    if ($suma_depusa > $suma_cont) {
        $msg = "Eroare: Suma de depus este mai mare decât suma disponibilă în cont.";
        header("Location: ../produse.php?msg=".urlencode($msg));
        exit();
    }

    // Scade suma depusă în depozit din suma curentă a contului clientului
    $suma_cont -= $suma_depusa;

    $query = "INSERT INTO depozite (id_client, data_depunere, data_expirare, rata_dobanda, suma_depusa, nume_depozit, perioada_depozit) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die("Eroare la pregătirea instrucțiunii SQL: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "issssss", $id_client, $data_depunere, $data_expirare, $rata_dobanda, $suma_depusa, $nume_depozit, $perioada_depozit);

    if (mysqli_stmt_execute($stmt)) {
        $id_depozit = mysqli_insert_id($conn);

        // Actualizează valoarea sumei în baza de date pentru contul clientului
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

    mysqli_stmt_close($stmt);
} else {
    echo "Eroare: ID-ul clientului nu a fost găsit în tabela conturi.";
}

mysqli_close($conn);

?>