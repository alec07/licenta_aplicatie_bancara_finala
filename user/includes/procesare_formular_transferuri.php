<?php
session_start();
include('db.inc.php');

if (isset($_POST['submit'])) {
  $nume_beneficiar = $_POST['nume_beneficiar'];
  $iban_beneficiar = $_POST['iban_beneficiar'];
  $suma_transfer = $_POST['suma_transfer'];
  $detalii_transfer = $_POST['detalii_transfer'];

  // Preia ID-ul contului sursă din tabela conturi pe baza IBAN-ului clientului conectat în sesiune
  $id_client_sursa = $_SESSION['id_client'];
  $query = "SELECT id_cont FROM conturi WHERE id_client = $id_client_sursa";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_cont_sursa = $row['id_cont'];

    // Verifică dacă există clientul beneficiar în tabela conturi
    $query_verificare_beneficiar = "SELECT * FROM conturi WHERE iban = '$iban_beneficiar'";
    $result_verificare_beneficiar = mysqli_query($conn, $query_verificare_beneficiar);

    if ($result_verificare_beneficiar && mysqli_num_rows($result_verificare_beneficiar) > 0) {
      // Există clientul beneficiar în baza de date

      // Actualizează contul clientului beneficiar
      $query_actualizare_beneficiar = "UPDATE conturi SET suma_depusa = suma_depusa + $suma_transfer WHERE iban = '$iban_beneficiar'";
      if (mysqli_query($conn, $query_actualizare_beneficiar)) {

        // Adaugă transferul în baza de date
        $query_adaugare_transfer = "INSERT INTO transferuri (id_client_sursa, id_client_destinatie, suma_transfer, detalii_transfer, nume_beneficiar, iban_beneficiar) VALUES ('$id_cont_sursa', (SELECT id_cont FROM conturi WHERE iban = '$iban_beneficiar'), '$suma_transfer', '$detalii_transfer','$nume_beneficiar','$iban_beneficiar')";
        if (mysqli_query($conn, $query_adaugare_transfer)) {
          $msg = "Transferul a fost efectuat cu succes!";
          header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
        } else {
          $msg = "Eroare la adăugarea transferului";
          header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
        }
      } else {
        $msg = "Eroare la actualizarea contului beneficiarului:";
        header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
      }
    } else {
      // Beneficiarul nu există în baza de date, se scad banii din contul clientului sursă
      echo "Beneficiarul nu există în baza de date. Se scad banii din contul clientului sursă.";
      // Adaugă transferul în baza de date
      $query_adaugare_transfer = "INSERT INTO transferuri (id_client_sursa, iban_beneficiar, suma_transfer, detalii_transfer, nume_beneficiar) VALUES ('$id_cont_sursa', '$iban_beneficiar', '$suma_transfer', '$detalii_transfer', '$nume_beneficiar')";
      if (mysqli_query($conn, $query_adaugare_transfer)) {
        $msg = "Transferul a fost efectuat cu succes!";
        header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));

      } else {
        $msg = "Eroare la adăugarea transferului";
        header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
      }
    }
  } else {
    $msg = "Clientul sursă nu există în baza de date.";
    header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
  }
} else {
  $msg = "Formularul nu a fost submitat.";
  header("Location: ../toate-transferurile.php?msg=" . urlencode($msg));
}

mysqli_close($conn);
?>
