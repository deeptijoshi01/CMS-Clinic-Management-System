<?php
session_start();

unset($_SESSION['loginstatus_patient']);
unset($_SESSION['patient_id']); 

session_destroy();

// Patient login page is OUTSIDE this folder, so go 2 steps back:
header("Location: ../../patient-login.php");
exit();
?>
