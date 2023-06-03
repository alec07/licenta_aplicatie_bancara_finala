<?php
    include('db.inc.php');
    if(isset($_POST['delete'])){
    $id_produs=$_POST['id_produs'];

    $query="DELETE FROM produse_bancare where id_produs='$id_produs'";
    $query_run=mysqli_query($conn,$query);

    if($query_run){

        $msg = "produsul a fost șters cu succes!";
        header("Location: ../produse.php?msg=".urlencode($msg));

    }else{
        $msg = "produsul nu a fost șters cu succes!";
        header("Location: ../produse.php?msg=".urlencode($msg));

}
}

