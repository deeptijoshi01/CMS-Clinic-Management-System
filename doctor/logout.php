<?php
session_start();
unset($_SESSION['loginstatus_doctor']);
header('location: doctor-login.php');
?>