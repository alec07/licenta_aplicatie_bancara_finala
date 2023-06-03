<?php require('partials/head.php') ?>
<?php
require_once('include/db.inc.php');
$query="select * from inregistrare_client WHERE user_type = 'user'";
$result=mysqli_query($conn,$query);
?>
<?php include ('partials/sidebar.php'); ?>

<div class="p-4 sm:ml-64">

</div>


<?php require('partials/footer.php') ?>