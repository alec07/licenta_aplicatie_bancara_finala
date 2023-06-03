<?php
include "db.inc.php";

if (isset($_GET["id_oras"])) {
    $id_oras = $_GET["id_oras"];

    // SQL pentru a șterge înregistrarea cu id_oras-ul dat
    $sql = "DELETE FROM orase WHERE id_oras = $id_oras";

    if (mysqli_query($conn, $sql)) {
        $msg = "Orasul a fost șters cu succes!";
        header("Location: ../judete.php?msg=".urlencode($msg));
    } else {
        echo "Eroare la ștergerea înregistrării: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
