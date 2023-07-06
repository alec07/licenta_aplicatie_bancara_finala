<?php


if(isset($_POST["submit"])){
    require('db.inc.php');

    if(empty($_POST['cnp'])){
        header('location:../inregistrare-client.php?error=emptyCNP');
        exit;
    }
    if(empty($_POST['nume'])){
        header('location:../inregistrare-client.php?error=emptyNUME');
        exit;
    }
    if(empty($_POST['initiala_t'])){
        header('location:../inregistrare-client.php?error=emptyINITIALA_T');
        exit;
    }
    if(empty($_POST['prenume'])){
        header('location:../inregistrare-client.php?error=emptyPRENUME');
        exit;
    }
    if(empty($_POST['email'])){
        header('location:../inregistrare-client.php?error=emptyEMAIL');
        exit;
    }
    if(empty($_POST['telefon'])){
        header('location:../inregistrare-client.php?error=emptyTELEFON');
        exit;
    }
    if(empty($_POST['adresa'])){
        header('location:../inregistrare-client.php?error=emptyADRESA');
        exit;
    }
    if(empty($_POST['orase'])){
        header('location:../inregistrare-client.php?error=emptyORAS');
        exit;
    }
    if(empty($_POST['tara'])){
        header('location:../inregistrare-client.php?error=emptyTARA');
        exit;
    }
    if(empty($_POST['data_nastere'])){
        header('location:../inregistrare-client.php?error=emptyDATA_NASTERE');
        exit;
    }
    if(empty($_POST['proprietate'])){
        header('location:../inregistrare-client.php?error=emptyPROPRIETATE');
        exit;
    }
    if(empty($_POST['ocupatie'])){
        header('location:../inregistrare-client.php?error=emptyOCUPATIE');
        exit;
    }
    if(empty($_POST['suma_depusa'])){
        header('location:../inregistrare-client.php?error=emptySUMA_DEPUSA');
        exit;
    }
    if(empty($_POST['numar_card'])){
        header('location:../inregistrare-client.php?error=emptyNUMAR_CARD');
        exit;
    }
    if(empty($_POST['cvv'])){
        header('location:../inregistrare-client.php?error=emptyCVV');
        exit;
    }
    if(empty($_POST['data_expirare'])){
        header('location:../inregistrare-client.php?error=emptyDATA_EXPIRARE');
        exit;
    }
    if(empty($_POST['data_deschidere'])){
        header('location:../inregistrare-client.php?error=emptyDATA_DESCHIDERE');
        exit;
    }
    if(empty($_POST['parola'])){
        header('location:../inregistrare-client.php?error=emptyPAROLA');
        exit;
    }
    if(empty($_POST['gen'])){
        header('location:../inregistrare-client.php?error=emptyGEN');
        exit;
    }
    if(empty($_POST['iban'])){
        header('location:../inregistrare-client.php?error=emptyIBAN');
        exit;
    }

    if( !empty($_POST['cnp']) && !empty($_POST['nume']) && !empty($_POST['prenume'])  && !empty($_POST['initiala_t']) && !empty($_POST['telefon']) && !empty($_POST['email']) && !empty($_POST['adresa']) && !empty($_POST['orase']) && !empty($_POST['tara']) && !empty($_POST['data_nastere']) && !empty($_POST['proprietate']) && !empty($_POST['ocupatie']) && !empty($_POST['gen']) && !empty($_POST['suma_depusa']) && !empty($_POST['numar_card']) && !empty($_POST['iban']) && !empty($_POST['data_expirare']) && !empty($_POST['cvv']) && !empty($_POST['data_deschidere']) && !empty($_POST['parola']))
    {
        // //checking valid email
        // if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //     header('location:../inregistrare-client.php?error=EMAILinvalid');
        //     exit;
        // }

        $cnp=mysqli_real_escape_string($conn,strip_tags($_POST['cnp']));
        $nume=mysqli_real_escape_string($conn,strip_tags($_POST['nume']));
        $initiala_t=mysqli_real_escape_string($conn,strip_tags($_POST['initiala_t']));
        $prenume=mysqli_real_escape_string($conn,strip_tags($_POST['prenume']));

        $email=mysqli_real_escape_string($conn,strip_tags($_POST['email']));
        $telefon=mysqli_real_escape_string($conn,strip_tags($_POST['telefon']));
        $adresa=mysqli_real_escape_string($conn,strip_tags($_POST['adresa']));
        $orase=mysqli_real_escape_string($conn,strip_tags($_POST['orase']));
        $tara=mysqli_real_escape_string($conn,strip_tags($_POST['tara']));
        $data_nastere=mysqli_real_escape_string($conn,strip_tags($_POST['data_nastere']));
        $proprietate=mysqli_real_escape_string($conn,strip_tags($_POST['proprietate']));
        $ocupatie=mysqli_real_escape_string($conn,strip_tags($_POST['ocupatie']));
        $gen=mysqli_real_escape_string($conn,strip_tags($_POST['gen']));
        $suma_depusa=mysqli_real_escape_string($conn,strip_tags($_POST['suma_depusa']));
        $numar_card=mysqli_real_escape_string($conn,strip_tags($_POST['numar_card']));
        $iban=mysqli_real_escape_string($conn,strip_tags($_POST['iban']));
        $cvv=mysqli_real_escape_string($conn,strip_tags($_POST['cvv']));
        $data_expirare=mysqli_real_escape_string($conn,strip_tags($_POST['data_expirare']));
        $data_deschidere=mysqli_real_escape_string($conn,strip_tags($_POST['data_deschidere']));
        $parola=mysqli_real_escape_string($conn,strip_tags(($_POST['parola'])));
        $parola_criptata=password_hash($parola, PASSWORD_DEFAULT);


        $sql = "INSERT INTO inregistrare_client (cnp,nume,initiala_t,prenume,email,telefon,adresa,oras,tara,data_nastere,proprietate,ocupatie,gen,suma_depusa,numar_card,cvv,data_expirare,data_deschidere,parola,iban) VALUES('$cnp','$nume','$initiala_t','$prenume','$email','$telefon','$adresa','$orase','$tara','$data_nastere','$proprietate','$ocupatie','$gen','$suma_depusa','$numar_card','$cvv','$data_expirare','$data_deschidere','$parola_criptata','$iban')";
        $inserted=mysqli_query($conn,$sql);
        if($inserted)
        {
            header('location:../inregistrare-client.php');
            exit;
        }else
        {
        header('location:../inregistrare-client.php?error=UserCreateFailed');
        exit;
        }
    }
}
// $stmt=$conn->prepare("insert into inregistrare_client(cnp,nume,prenume,stare_civila,initiala_t,telefon,email,adresa,oras,tara,data_nastere,proprietate,ocupatie,gen,suma_depusa,numar_card,iban,cvv,data_expirare,data_deschidere,parola) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
//     $stmt->bind_param("sssssssssssssssssssss",$cnp,$nume,$prenume,$stare_civila,$initiala_t,$telefon,$email,$adresa,$oras,$tara,$data_nastere,$proprietate,$ocupatie,$gen,$suma_depusa,$numar_card,$iban,$cvv,$data_expirare,$data_deschidere,$parola);
//     $stmt->execute();
//     $inserted=mysqli_query($conn,$stmt);
//     if($inserted){
//         header('location:../inregistrare-client.php?error=UserCreated');
//         exit;
//     }else{
//         header('location:../inregistrare-client.php?error=UserCreateFailed');
//     }
//     $stmt->close();
//     $conn->close();




// $sql="INSERT INTO inregistrare_client(cnp,nume,prenume,stare_civila,initiala_t,telefon,email,adresa,oras,tara,data_nastere,proprietate,ocupatie,gen,suma_depusa,numar_card,iban,cvv,data_expirare,data_deschidere,parola) VALUES ('";
// INSERT INTO inregistrare_client($cnp,$nume,$prenume,$stare_civila,$initiala_t,$telefon,$email,$adresa,$oras,$tara,$data_nastere,$proprietate,$ocupatie,$gen,$suma_depusa,$numar_card,$iban,$cvv,$data_expirare,$data_deschidere,$parola) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)

?>
