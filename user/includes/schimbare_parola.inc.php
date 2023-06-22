<?php
session_start();
include('db.inc.php');

// Verificăm dacă a fost trimis formularul
if (isset($_POST['schimbaParola'])) {
    // Preluăm valorile introduse în câmpurile de parolă
    $parolaVeche = $_POST['parolaVeche'];
    $parolaNoua = $_POST['parolaNoua'];
    $confirmareParola = $_POST['confirmareParola'];

    // Verificăm dacă parola nouă și confirmarea parolei coincid
    if ($parolaNoua === $confirmareParola) {
        // Verificăm dacă parola veche introdusă este corectă
        // Exemplu simplu: comparăm cu o parolă stocată anterior în baza de date
        $idUtilizator = $_SESSION['id_client']; // Preluăm ID-ul utilizatorului din sesiune
        $query = "SELECT parola FROM inregistrare_client WHERE id_client = '$idUtilizator'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $parolaStocata = $row['parola'];

            if (password_verify($parolaVeche, $parolaStocata)) {
                // Parola veche introdusă este corectă, actualizăm parola în baza de date
                $parolaCriptata = password_hash($parolaNoua, PASSWORD_DEFAULT);
                $queryUpdate = "UPDATE inregistrare_client SET parola = '$parolaCriptata' WHERE id_client = '$idUtilizator'";
                $resultUpdate = mysqli_query($conn, $queryUpdate);

                if ($resultUpdate) {
                    // Parola a fost actualizată cu succes
                    $msg = "Parola a fost schimbată cu succes!";
                    header("Location: ../setari.php?msg=" . urlencode($msg));
                    exit();
                } else {
                    // A apărut o eroare la actualizarea parolei în baza de date
                    $msg = "A apărut o eroare la schimbarea parolei. Te rugăm să încerci din nou.";
                    header("Location: ../setari.php?msg=" . urlencode($msg));
                    exit();
                }
            } else {
                // Parola veche introdusă nu este corectă
                $msg = "Parola veche introdusă nu este corectă.";
                header("Location: ../setari.php?msg=" . urlencode($msg));
                exit();
            }
        } else {
            // Nu s-a găsit utilizatorul în baza de date
            $msg = "Utilizatorul nu există.";
            header("Location: ../setari.php?msg=" . urlencode($msg));
            exit();
        }
    } else {
        // Afiseaza un mesaj de eroare

        $msg = "Parola nouă și confirmarea parolei nu coincid.";
        header("Location: ../setari.php?msg=" . urlencode($msg));
        exit();
    }
}
?>
