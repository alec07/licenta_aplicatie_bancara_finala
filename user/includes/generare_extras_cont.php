<?php
session_start();
include('db.inc.php');


if (isset($_POST['generateExtras'])) {
    // Obțineți datele de început și de sfârșit din formularul modal
    $dataStart = $_POST['dataStart'];
    $dataEnd = $_POST['dataEnd'];

    // Obținerea tranzacțiilor din baza de date
    $sql = "SELECT * FROM transferuri WHERE data_transfer BETWEEN '$dataStart' AND '$dataEnd'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Crearea unui fișier CSV
        $filename = 'extras_cont.csv';

        // Deschiderea fișierului în modul de scriere
        $file = fopen($filename, 'w');

        // Scrierea antetelor coloanelor
        $header = ['Nume Beneficiar', 'Detalii despre transfer', 'Suma transferata','Data transferului','Iban Beneficiar transfer'];
        fputcsv($file, $header);

        // Scrierea tranzacțiilor în fișierul CSV
        while ($row = $result->fetch_assoc()) {
            $data = [$row['nume_beneficiar'], $row['detalii_transfer'], $row['suma_transfer'], $row['data_transfer'], $row['iban_beneficiar']];
            fputcsv($file, $data);
        }

        // Închiderea fișierului
        fclose($file);

        // Descărcarea fișierului CSV
        header("Content-disposition: attachment; filename=$filename");
        header("Content-type: text/csv");
        header("Content-Length: " . filesize($filename));
        readfile($filename);

        // Ștergerea fișierului CSV
        unlink($filename);
    } else {
        echo "Nu s-au găsit tranzacții în perioada selectată.";
    }
}

// Închiderea conexiunii la baza de date
$conn->close();
?>
