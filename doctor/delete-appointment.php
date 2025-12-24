<?php
require_once('../includes/db_connect.php');

if (!isset($_GET['aid']) || empty($_GET['aid'])) {
    header("Location: total-appointments.php");
    exit();
}

$aid = intval($_GET['aid']);

// DELETE appointment
$query = "DELETE FROM cms_appointments WHERE appointment_id = $aid";
mysqli_query($conn, $query);

// Redirect back with message
header("Location: total-appointments.php?deleted=1");
exit();
?>
