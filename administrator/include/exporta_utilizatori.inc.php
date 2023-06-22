<?php
include 'db.inc.php';

// Verificați dacă s-a făcut clic pe butonul de export
if (isset($_POST['export'])) {

    // Verificați dacă există date de filtrare în $_POST
    if (isset($_POST['dataInceput']) && isset($_POST['dataSfarsit'])) {
        // Obțineți datele de filtrare din formular
        $dataInceput = $_POST['dataInceput'];
        $dataSfarsit = $_POST['dataSfarsit'];
    } else {
        // Dacă datele de filtrare lipsesc, setați-le la valori implicite sau utilizați altă logică, după caz
        $dataInceput = '1970-01-01';
        $dataSfarsit = '2030-12-31';
    }

    // Numele fișierului CSV
    $filename = 'export.csv';

    // Creați un fișier nou pe server
    $file = fopen($filename, 'w');

    // Verificați dacă fișierul a fost creat cu succes
    if (!$file) {
        die('Nu se poate crea fișierul CSV.');
    }

    // Setarea antetelor
    $header = array('Nume', 'Initiala Tata', 'Prenume', 'Data Nastere', 'Oras', 'Data deschidere');
    fputcsv($file, $header);

    // Efectuați interogarea SQL pentru a obține rezultatele filtrate
    $query = "SELECT * FROM inregistrare_client WHERE user_type = 'user' AND ((data_nastere BETWEEN '$dataInceput' AND '$dataSfarsit') OR (data_deschidere BETWEEN '$dataInceput' AND '$dataSfarsit'))";
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

    // Redirecționează utilizatorul către fișierul CSV salvat pe server
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    unlink($filename);
    exit;
}
?>