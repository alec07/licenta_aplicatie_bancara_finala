<?php
include('includes/db.inc.php');
// Pornirea sesiunii
session_start();
// Pornirea sesiunii


// Verificarea informațiilor de autentificare
if (isset($_POST['email']) && isset($_POST['parola'])) {
    $email = $_POST['email'];
    $parola = $_POST['parola'];

    // Verificarea informațiilor de autentificare în baza de date
    $query = "SELECT * FROM inregistrare_client WHERE email='$email' AND parola='$parola'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Autentificarea reușită
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['id_client'] = $user_data['id_client'];
        $_SESSION['email'] = $user_data['email'];
        $autentificare_reusita = true;
    } else {
        // Autentificarea a eșuat
        $autentificare_reusita = false;
        echo "Informațiile de autentificare sunt incorecte.";
    }
}

// Verificarea existenței unei sesiuni valide pentru utilizatorul curent
if (isset($_SESSION['email']) && $autentificare_reusita) {
    // Utilizarea informațiilor stocate în variabilele de sesiune
    $id_client = $_SESSION['id_client'];
    $email = $_SESSION['email'];

    // Afisarea numelor utilizatorului
    echo "Bun venit, " . $email;
} else {
    // Dacă utilizatorul nu este autentificat, afișați un mesaj de eroare sau redirecționați-l către pagina de autentificare
    echo "Nu sunteți autentificat";
}
?>
