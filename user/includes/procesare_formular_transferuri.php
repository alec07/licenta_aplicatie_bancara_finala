<?php
session_start();
include('db.inc.php');
// Obțin contul destinatar introdus de utilizator din formular
$id_client_destinatie = $_POST['id_client_destinatie'];
// Obțin suma transferată introdusă de utilizator din formular
$suma_transfer = $_POST['suma_transfer'];


// preiau ID-ul contului sursa din tabela conturi pe baza IBAN-ului clientului conectat in sesiune
$id_client = $_SESSION['id_client'];
$query = "SELECT id_cont FROM conturi WHERE id_client = $id_client";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();
$id_client_sursa = $row['id_cont'];


// Caut ID-ul clientului destinatar în baza de date
$query = "SELECT id_cont FROM conturi WHERE iban = '$id_client_destinatie'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $id_client_destinatie = $row['id_cont'];

  // Actualizez suma_depusaul contului clientului sursă
  $query = "UPDATE conturi SET suma_depusa = suma_depusa - $suma_transfer WHERE id_cont = $id_client_sursa";
  mysqli_query($conn, $query);

  // Actualizez suma_depusaul contului clientului destinatar
  $query = "UPDATE conturi SET suma_depusa = suma_depusa + $suma_transfer WHERE id_cont = $id_client_destinatie";
  mysqli_query($conn, $query);

  // Adug o nouă înregistrare în tabela transferuri
  $query = "INSERT INTO transferuri (id_client_sursa, id_client_destinatie, suma_transfer, detalii_transfer) VALUES ($id_client_sursa, $id_client_destinatie, $suma_transfer, 'Transfer bancar')";
  mysqli_query($conn, $query);
  $msg = "Transferul a fost efectuat cu succes!";
  header("Location: ../transferuri.php?msg=".urlencode($msg));

} else {
  echo "Contul destinatar nu a putut fi găsit în baza de date.";
}

mysqli_close($conn);
?>