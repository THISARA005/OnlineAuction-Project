<?php 
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'eauction';
$conn = mysqli_connect($host , $user , $password , $db ) or die('Db Connection failed' . mysqli_connect_error());
session_start();
if(isset($_SESSION['bu_userid'])){
    header("Location: overview.php");}
    else{
        header("Location: http://localhost/MyFolder/MarqueBeyond/MarqueBeyond/");
    }
    mysqli_close($conn);
?>