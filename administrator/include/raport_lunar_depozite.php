<?php
include 'db.inc.php';
// Conectați-vă la baza de date sau includeți fișierul de configurare a bazei de date

// Executați interogarea și obțineți rezultatele
if (isset($_POST['generate-monthly-report'])) {
    // Efectuați interogarea pentru a prelua depozitele din baza de date
    // Obțineți depozitele deschise în luna curentă din baza de date
$month = date('m');
$year = date('Y');
$query = "SELECT * FROM depozite WHERE MONTH(data_depunere) = $month AND YEAR(data_depunere) = $year";
    $result = mysqli_query($conn, $query);

    // Verificați dacă există depozite în rezultat
    if (mysqli_num_rows($result) > 0) {
        // Deschideți un fișier CSV în modul de scriere
        $file = fopen('raport_financiar.csv', 'w');

        // Adăugați antetele de coloană în fișierul CSV
        $header = array('Numar depozit', 'Titular', 'Suma', 'Durata', 'Dobanda', 'Data deschidere', 'Stare');
        fputcsv($file, $header);

        // Iterați prin fiecare rând de depozit
        while ($row = mysqli_fetch_assoc($result)) {
            // Extrageți informațiile despre depozit din rândul curent
            $numarDepozit = $row['id_depozit'];
            $idClient = $row['id_client'];
            $suma = $row['suma_depusa'];
            $durata = $row['perioada_depozit'];
            $dobanda = $row['rata_dobanda'];
            $dataDeschidere = $row['data_depunere'];

            // Verificați valoarea coloanei 'expirat'
            $expirat = $row['expirat'];
            if ($expirat == 0) {
                $stare = "Activ";
            } elseif ($expirat == 1) {
                $stare = "Expirat";
            }

            // Interogați tabela 'clienti' pentru a obține numele titularului
            $queryClient = "SELECT nume FROM inregistrare_client WHERE id_client = $idClient";
            $resultClient = mysqli_query($conn, $queryClient);
            $rowClient = mysqli_fetch_assoc($resultClient);
            $titular = $rowClient['nume'];

            // Adăugați valorile în fișierul CSV
            $data = array($numarDepozit, $titular, $suma, $durata, $dobanda, $dataDeschidere, $stare);
            fputcsv($file, $data);
        }

        // Închideți fișierul CSV
        fclose($file);

        // Descărcați fișierul CSV generat
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="raport_financiar.csv"');
        readfile('raport_financiar.csv');

        // Terminați execuția scriptului
        exit;
    }else {
        // Nu există depozite deschise în luna curentă
        $msg = "Nu există depozite deschise în luna curentă";
        header("Location: ../depozite_deschise.php?msg=".urlencode($msg));
    }
}

?>

