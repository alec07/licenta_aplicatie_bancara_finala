<?php
include "db.inc.php";

if (isset($_GET["id_produs"])) {
    $id_produs = $_GET["id_produs"];

    // SQL pentru a șterge înregistrarea cu id_produs-ul dat
    $sql = "DELETE FROM produse_bancare WHERE id_produs = ?";

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_produs);

    if (mysqli_stmt_execute($stmt)) {
        $msg = "Produsul a fost șters cu succes!";
        header("Location: ../produse.php?msg=" . urlencode($msg));
        exit();
    } else {
        echo "Eroare la ștergerea înregistrării: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
