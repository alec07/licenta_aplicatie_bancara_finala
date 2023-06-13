<?php
session_start();
include('db.inc.php');

if (isset($_POST['expira_depozit'])) {
    $idDepozit = $_POST['id_depozit'];

    // Selectați depozitul pe baza id-ului
    $query = "SELECT * FROM depozite WHERE id_depozit = $idDepozit";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Actualizați valoarea coloanei "expirat" în 1 în tabela "depozite"
    $query = "UPDATE depozite SET expirat = 1 WHERE id_depozit = $idDepozit";
    mysqli_query($conn, $query);


    mysqli_query($conn, $query);

    // Actualizați suma în contul clientului
    $id_client = $_SESSION['id_client'];
    $suma_depusa = $row['suma_depusa'];
    $rata_dobanda = $row['rata_dobanda'];
    $sumaFinala = $suma_depusa + ($suma_depusa * $rata_dobanda / 100);

    $query = "UPDATE conturi SET suma_depusa = suma_depusa + $sumaFinala WHERE id_client = $id_client";
    mysqli_query($conn, $query);

    // Redirecționați utilizatorul către pagina corespunzătoare
    header("Location: ../dashboard.user.php");
    exit();
}

mysqli_close($conn);
?>
