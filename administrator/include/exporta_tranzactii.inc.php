<?php
include 'db.inc.php';

// Verificați dacă s-a făcut clic pe butonul de export
if (isset($_POST['export'])) {
    // Efectuați interogarea SQL pentru a obține toate rezultatele
    $query = "SELECT ic.nume AS nume_sursa, ic.prenume AS prenume_sursa, c.iban, t.nume_beneficiar AS nume_destinatie, t.iban_beneficiar, t.detalii_transfer, t.data_transfer, t.suma_transfer, t.id_transfer
                                    FROM transferuri t
                                    LEFT JOIN plati_facturi p ON t.id_client_sursa = p.id_client
                                    LEFT JOIN conturi c ON t.id_client_sursa = c.id_cont
                                    LEFT JOIN inregistrare_client ic ON c.id_client = ic.id_client
                                    ";
    $result = mysqli_query($conn, $query);

    // Verificați dacă există rezultate
    if (mysqli_num_rows($result) > 0) {
        // Numele fișierului CSV
        $filename = 'export_tranzactii.csv';

        // Creați un fișier nou pe server
        $file = fopen($filename, 'w');

        // Verificați dacă fișierul a fost creat cu succes
        if (!$file) {
            die('Nu se poate crea fișierul CSV.');
        }

        // Scrieți antetul în fișierul CSV
        $headers = array("ID Transfer", "IBAN", "Nume Sursă", "Nume Destinație", "IBAN Beneficiar", "Suma Transfer", "Data Transfer");
        fputcsv($file, $headers);

        // Iterați prin rezultate și scrieți fiecare rând în fișierul CSV
        while ($row = mysqli_fetch_assoc($result)) {
            $data = array(
                $row["id_transfer"],
                $row["iban"],
                $row["nume_sursa"] . " " . $row["prenume_sursa"],
                $row["nume_destinatie"],
                $row["iban_beneficiar"],
                $row["suma_transfer"],
                $row["data_transfer"]
            );
            fputcsv($file, $data);
        }

        // Închideți fișierul CSV
        fclose($file);

        // Descărcați fișierul CSV generat
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export_tranzactii.csv"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . ob_get_length());
        readfile($filename);

        // Terminați execuția scriptului
        exit;
    } else {
        // Nu există rezultate pentru export
        echo "Nu există date pentru export.";
    }
}


