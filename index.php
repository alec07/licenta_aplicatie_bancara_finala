<?php require('includes/db.inc.php'); ?>
<?php include ('partials/header.php'); ?>
<!--Nav-->
<?php include ('partials/navbar.php'); ?>


<!--Main-->

<div class="flex items-center  flex-col h-screen">

    <?php
        // Query pentru a prelua textul din tag-urile H1
        $sql = "SELECT h1_text FROM index_page";
        $result = $conn->query($sql);
         if ($result->num_rows > 0) {
        // Afisarea textului din tag-urile H1 în div
        while ($row = $result->fetch_assoc()) {
            echo '<h1 class="text-4xl mb-4 font-bold font-serif">' . $row["h1_text"] . '</h1>';
        }
    } else {
        echo "Nu există rezultate.";
    } ?>
    <?php
        // Query pentru a prelua textul din tag-urile H1
        $sql2 = "SELECT h2_text FROM index_page";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            // Afisarea textului din tag-urile H2 în div
            while ($row = $result2->fetch_assoc()) {
                echo '<h2 class="text-2xl text-secondary-500 mb-4 font-bold font-serif">' . $row["h2_text"] . '</h2>';
            }
        } else {
            echo "Nu există rezultate.";
        }
    ?>

    <button class=" text-black font-bold py-2 px-4 font-serif rounded">
        <a href="despreapp.php">Află mai multe -></a>
    </button>

</div>
<?php include ('partials/bottom.php'); ?>
<?php include ('partials/footer.php'); ?>