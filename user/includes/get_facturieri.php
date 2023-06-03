<?php
include('db.inc.php');
session_start();

// preluam datele din formular
$suma_plata = $_POST['suma_plata'];
$cod_client = $_POST['cod_client'];
$nume = $_POST['nume'];
$iban = $_POST['iban'];

// preluam id-ul facturierului pe baza numelui si iban-ului
$sql_facturier = "SELECT id_facturier FROM facturieri WHERE nume = '$nume' AND iban = '$iban'";
$result_facturier = $conn->query($sql_facturier);


if ($result_facturier->num_rows > 0) {
    // gasim facturierul in baza de date
    $row_facturier = $result_facturier->fetch_assoc();
    $id_facturier = $row_facturier['id_facturier'];

    // preluam id-ul clientului din tabela conturi pe baza id_client conectat in sesiune
    $id_client = $_SESSION['id_client'];

    // inseram datele in tabela plati
    $sql_plati = "INSERT INTO plati_facturi (id_facturier, id_client, suma_plata, cod_client) VALUES ('$id_facturier', '$id_client', '$suma_plata', '$cod_client')";
    // actualizăm suma din contul clientului
$sql_conturi = "UPDATE conturi SET suma_depusa = suma_depusa - $suma_plata WHERE id_client = $id_client";
if ($conn->query($sql_conturi) === TRUE) {
    $msg = "";
  header("Location: ../plati.php?msg=".urlencode($msg));
} else {
    echo "Eroare la actualizarea sumei din cont: " ;
}
    if ($conn->query($sql_plati) === TRUE) {
        $msg = "Datele au fost adaugate cu succes.";
        header("Location: ../plati.php?msg=".urlencode($msg));
    } else {
      echo "Error: " ;
    }

  } else {
    $msg = "Nu am putut gasi facturierul in baza de date.";
    header("Location: ../plati.php?msg=".urlencode($msg));
  }

  $conn->close();




?>