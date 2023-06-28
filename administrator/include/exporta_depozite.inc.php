<?php
include 'db.inc.php';
// Verificați dacă butonul "Generați raport" a fost apăsat
if (isset($_POST['generate-financial-report'])) {
    // Efectuați interogarea pentru a prelua depozitele din baza de date
    $query = "SELECT * FROM depozite";
    $result = mysqli_query($conn, $query);

    // Verificați dacă există depozite în rezultat
    if (mysqli_num_rows($result) > 0) {
        // Deschideți un fișier CSV în modul de scriere
        $file = fopen('raport_financiar.csv', 'w');

        // Adăugați antetele de coloană în fișierul CSV
        $header = array('Număr depozit', 'Titular', 'Sumă', 'Durată', 'Dobândă', 'Data deschidere', 'Stare');
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
    }
}


?>