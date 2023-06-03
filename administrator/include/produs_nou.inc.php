<?php
include 'db.inc.php';
// Verificăm dacă formularul a fost trimis
if(isset($_POST['submit'])){

    $nume_produs = $_POST['nume_produs'];


    // Actualizarea datelor in baza de date
    $sql = "INSERT INTO `produse_bancare` (nume_produs) VALUES ('$nume_produs')";
    $result=mysqli_query($conn,$sql);
    if($result){
        header('location:../produse.php');
    }else{
        die(mysqli_error($conn));
    }

    // Inchidem conexiunea la baza de date
    $conn->close();
}
?>
