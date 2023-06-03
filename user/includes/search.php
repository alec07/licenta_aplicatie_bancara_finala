<?php
session_start();
include('db.inc.php');


  // construiește interogarea SQL
  $sql = "SELECT * FROM table_name WHERE column_name LIKE '%$searchTerm'";

  // rulează interogarea și prelucrează rezultatele
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // afișează rezultatele
    while($row = $result->fetch_assoc()) {
      echo "<p>" . $row["column_name"] . "</p>";
    }
  } else {
    echo "Nu s-au găsit rezultate.";
  }

  // închide conexiunea la baza de date
  $conn->close();



?>