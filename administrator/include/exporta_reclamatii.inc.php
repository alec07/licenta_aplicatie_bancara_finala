<?php
include 'db.inc.php';

// Numele fișierului CSV
$filename = 'reclamatii_raport.csv';
// Creați un fișier nou
$file = fopen($filename, 'w');
// Verificați dacă fișierul a fost creat cu succes
if (!$file) {
    die('Nu se poate crea fișierul CSV.');
}

// Setarea antetelor
$header = array( 'Nr. Reclamatie', 'Nume Reclamant', 'Nr. Telefon', 'Subiect', 'Mesaj', 'Data');
fputcsv($file, $header);

// Efectuați interogarea SQL pentru a obține rezultatele
$query = "SELECT * FROM formular_reclamatii";
$result = mysqli_query($conn, $query);

// Verificați dacă există rezultate
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = array(

            $row['id'],
            $row['nume_reclamant'],
            $row['nr_telefon'],
            $row['subiect_reclamatie'],
            $row['mesaj_reclamatie'],
            $row['data_reclamatie'],

        );
        fputcsv($file, $data);
    }

} else {
    echo "Nu există înregistrări disponibile.";
}

// Închideți fișierul
fclose($file);

// Descărcarea fișierului
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
?>
