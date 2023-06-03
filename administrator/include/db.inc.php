<?php
$host="localhost";
$user="root";
$password="";
$db="licenta-final2";
$conn=mysqli_connect($host,$user,$password,$db);
if(!$conn){
    die("Can't connect to database: ".mysqli_connect_error());
}
?>