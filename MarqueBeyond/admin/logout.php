<?php 
session_start();
session_unset();
session_destroy();
require_once('../db/config.php');
header("Location: {$hostname}admin/index.php");

?>