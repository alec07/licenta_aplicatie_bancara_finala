<?php
include "db.inc.php";

if (isset($_POST["id_depozit"])) {
    $numarDepozit = $_POST["id_depozit"];

    // SQL pentru a șterge înregistrarea cu id_depozit-ul dat
    $sql = "DELETE FROM depozite WHERE id_depozit = $numarDepozit";

    if (mysqli_query($conn, $sql)) {
        $msg = "Depozitul a fost șters cu succes!";
        header("Location: ../depozite_deschise.php?msg=".urlencode($msg));
        exit(); // Terminăm execuția scriptului după redirecționare
    } else {
        echo "Eroare la ștergerea înregistrării: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
