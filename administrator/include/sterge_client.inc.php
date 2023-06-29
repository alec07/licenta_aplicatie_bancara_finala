<?php
include 'db.inc.php';

// Verificați dacă a fost trimisă o cerere POST pentru ștergere
if (isset($_POST['delete'])) {
    // Verificați dacă a fost trimis un ID de client valid
    if (isset($_POST['id_client']) && !empty($_POST['id_client'])) {
        $id_client = $_POST['id_client'];

        // Executați interogarea pentru ștergerea înregistrării din tabela inregistrare_client
        $query_delete_client = "DELETE FROM inregistrare_client WHERE id_client = '$id_client'";
        $result_delete_client = mysqli_query($conn, $query_delete_client);

        if ($result_delete_client) {
            // Ștergerea a fost realizată cu succes, redirecționați utilizatorul către pagina dorită după ștergere
            header("Location: ../utilizatori.php");
            exit;
        } else {
            // A apărut o eroare la ștergerea înregistrării
            echo "Eroare la ștergerea clientului din tabela inregistrare_client: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "ID de client invalid.";
    }
}
?>
