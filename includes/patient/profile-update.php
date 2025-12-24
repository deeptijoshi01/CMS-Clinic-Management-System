<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../patient-login.php");
    exit();
}

$patient_id = (int) $_POST['patient_id'];
$full_name  = mysqli_real_escape_string($conn, $_POST['full_name']);
$age        = (int) $_POST['age'];
$phone      = mysqli_real_escape_string($conn, $_POST['phone']);
$email      = mysqli_real_escape_string($conn, $_POST['email']);
$gender     = mysqli_real_escape_string($conn, $_POST['gender']);

$update = "
    UPDATE cms_patients 
    SET full_name = '$full_name',
        age = '$age',
        phone = '$phone',
        email = '$email',
        gender = '$gender'
    WHERE patient_id = '$patient_id'
";

if (mysqli_query($conn, $update)) {
    header("Location: profile-management.php?updated=1");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
