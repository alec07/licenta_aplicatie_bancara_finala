<?php
include 'db.inc.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $perioada = isset($_GET['perioada']) ? $_GET['perioada'] : 'toate';

    // Construiește interogarea bazată pe perioada selectată
    $query = "SELECT COUNT(*) AS total_depozite, SUM(suma_depusa) AS suma_totala FROM depozite";

    if ($perioada === 'ultima-luna') {
        $query .= " WHERE data_depunere >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    } elseif ($perioada === 'ultimul-trimestru') {
        $query .= " WHERE data_depunere >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
    }

    // Efectuează interogarea și prelucrează rezultatele
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $totalDepozite = $row['total_depozite'];
    $sumaTotala = $row['suma_totala'];

    // Închide rezultatul interogării
    mysqli_free_result($result);

    // Verifică dacă există depozite pe perioada selectată și construiește mesajul corespunzător
    $message = '';
    if ($totalDepozite == 0) {
        if ($perioada === 'ultima-luna') {
            $message = 'Nu există depozite în ultima lună.';
        } elseif ($perioada === 'ultimul-trimestru') {
            $message = 'Nu există depozite în ultimul trimestru.';
        } else {
            $message = 'Nu există depozite disponibile.';
        }
    }

    // Returnează rezultatele și mesajul sub formă de JSON
    $response = [
        'totalDepozite' => $totalDepozite,
        'sumaTotala' => $sumaTotala,
        'message' => $message
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>






