<?php require('includes/db.inc.php'); ?>
<?php include ('partials/header2.php'); ?>
<?php include ('partials/navbar2.php'); ?>

<div class="mt-20 max-w-4xl mx-auto">
    <!-- conținutul paginii -->
    <a href="index.php" class="text-gray-300 font-bold">Home</a>
    <span class="text-gray-200 mx-2">/</span>
    <a href="despreapp.php" class="text-gray-300">Welcome to CeloBank</a>
    <span class="text-gray-200 mx-2">/</span>
    <a href="istoricbanca.php" class="text-gray-300">Istoric</a>
    <div class="mt-5 mb-5">
        <h1 class="text-orange-200 font-serif text-4xl">Cum s-a înființat banca</h1>
    </div>
    <div class="text-gray-500">

        <p class="mb-5">
        <?php
                // Query pentru a prelua textul din tag-urile H1
                $sql2 = "SELECT h2_text FROM istoric_page";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    // Afisarea textului din tag-urile H2 în div
                    while ($row = $result2->fetch_assoc()) {
                        echo '<h2 class="mb-10">' . nl2br(str_replace('\n', '<br><br>', $row["h2_text"])) . '</h2>';
                    }
                } else {
                    echo "Nu există rezultate.";
                }
            ?>
        </p>



    </div>
</div>
<?php include ('partials/bottom.php'); ?>
<?php include ('partials/footer.php'); ?>