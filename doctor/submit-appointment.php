<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../send_mail.php';

// Ensure this is POST
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("Invalid Request");
}

// Collect form data
$full_name  = mysqli_real_escape_string($conn, trim($_POST['full_name']));
$phone      = mysqli_real_escape_string($conn, trim($_POST['phone']));
$email      = mysqli_real_escape_string($conn, trim($_POST['email']));
$age        = intval($_POST['age']);
$gender     = mysqli_real_escape_string($conn, trim($_POST['gender']));
$appointment_date = $_POST['appointment_date'];
$description      = mysqli_real_escape_string($conn, trim($_POST['description']));

if (empty($full_name) || empty($phone) || empty($appointment_date)) {
    die("Required fields missing");
}

// CHECK IF PATIENT EXISTS
$check = mysqli_query($conn, "SELECT * FROM cms_patients WHERE phone='$phone' LIMIT 1");

if (mysqli_num_rows($check) > 0) {

    // EXISTING PATIENT
    $p = mysqli_fetch_assoc($check);
    $patient_id = $p['patient_id'];

    $verification_code = rand(100000, 999999);

    // FIXED PASSWORD LOGIC
    if (!empty($p['password'])) {
        $password = $p['password'];
    } else {
        $password = rand(10000, 99999);
        mysqli_query($conn, "
            UPDATE cms_patients 
            SET password='$password'
            WHERE patient_id='$patient_id'
        ");
    }

    // Update OTP
    mysqli_query($conn, "
        UPDATE cms_patients 
        SET verification_code='$verification_code', is_verify='pending'
        WHERE patient_id='$patient_id'
    ");

} else {

    // NEW PATIENT
    $verification_code = rand(100000, 999999);
    $password = rand(10000, 99999);

    mysqli_query($conn, "
        INSERT INTO cms_patients 
        (full_name, phone, email, age, gender, password, verification_code, is_verify, created_at)
        VALUES ('$full_name','$phone','$email',$age,'$gender','$password','$verification_code','pending',NOW())
    ");

    $patient_id = mysqli_insert_id($conn);
}

// CREATE APPOINTMENT
mysqli_query($conn, "
    INSERT INTO cms_appointments 
    (patient_id, appointment_date, description, status, created_by, create_at)
    VALUES ($patient_id, '$appointment_date', '$description', 'pending', 'patient', NOW())
");

// SEND EMAIL
send_verification_email($email, $full_name, $verification_code, $password, $patient_id);

// REDIRECT TO VERIFY MESSAGE PAGE
header("Location: ../verify-message.php?id=" . $patient_id);
exit;

?>
