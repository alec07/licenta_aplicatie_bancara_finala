<?php
$host="localhost";
$user="root";
$password="";
$db="licenta-final2";
$conn=mysqli_connect($host,$user,$password,$db);
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$email=$_POST["email"];
	$parola=$_POST["parola"];
	$sql="SELECT id_client, user_type, parola FROM inregistrare_client WHERE email='".$email."'";
	$result=mysqli_query($conn,$sql);
	if (mysqli_num_rows($result) > 0) {
		// există cel puțin o înregistrare în rezultatul interogării
		$row = mysqli_fetch_array($result);
		if (password_verify($parola, $row['parola'])) {
			// parola este corectă
			if ($row["user_type"] == "user") {
				$_SESSION["email"]=$email;
				$_SESSION["id_client"] = $row["id_client"];
				header("location: user/dashboard.user.php");
			} elseif ($row["user_type"] == "admin") {
				header("location: administrator/dashboard.admin.php");
			} else {
				$_SESSION["email"]=$email;
                $_SESSION['error'] = "Adresa de email sau parola introduse sunt incorecte.";
                header('Location: login.php');
			}
		} else {
			// parola este incorectă
            $_SESSION['error'] = "Adresa de email sau parola introduse sunt incorecte.";
            header('Location: login.php');
		}
	} else {
		// nu există înregistrări în rezultatul interogării
        $_SESSION['error'] = "Adresa de email sau parola introduse sunt incorecte.";
        header('Location: login.php');
	}
}
?>