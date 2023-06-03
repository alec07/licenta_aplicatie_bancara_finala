<?php
require_once('db.inc.php');
if(isset($_POST['delete'])){
$id_client=$_POST['id_client'];
$query="DELETE FROM inregistrare_client where id_client='$id_client'";
$query_run=mysqli_query($conn,$query);
if($query_run){
    $msg = "Clientul a fost șters cu succes!";
    header("Location: ../utilizatori.php?msg=".urlencode($msg));
}else{
    $msg = "Clientul nu a fost șters cu succes!";
    header("Location: ../utilizatori.php?msg=".urlencode($msg));

}
}

