<?php
include 'db.inc.php';

// Numele fișierului CSV
$filename = 'export.csv';

// Creați un fișier nou
$file = fopen($filename, 'w');

// Verificați dacă fișierul a fost creat cu succes
if (!$file) {
    die('Nu se poate crea fișierul CSV.');
}

// Setarea antetelor
$header = array( 'Nume', 'Initiala Tata', 'Prenume', 'Data Nastere', 'Oras', 'Data deschidere');
fputcsv($file, $header);

// Efectuați interogarea SQL pentru a obține rezultatele
$query = "SELECT * FROM inregistrare_client WHERE user_type = 'user' ";
$result = mysqli_query($conn, $query);

// Verificați dacă există rezultate
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Obțineți numele orașului bazat pe ID-ul orașului
        $id_oras = $row['oras'];
        $query_oras = "SELECT nume_oras FROM orase WHERE id_oras = $id_oras";
        $result_oras = mysqli_query($conn, $query_oras);
        $oras = mysqli_fetch_assoc($result_oras)['nume_oras'];

        // Formatați data deschiderii fără ora
        $data_deschidere = date('Y-m-d', strtotime($row['data_deschidere']));

        $data = array(

            $row['nume'],
            $row['initiala_t'],
            $row['prenume'],
            $row['data_nastere'],
            $oras, // Utilizați numele orașului în loc de ID
            $data_deschidere // Utilizați doar data fără ora
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
