<?php 
session_start();
require_once('../includes/db_connect.php');
require_once('functions.php');

if (!isset($_SESSION['loginstatus_doctor'])) {
    header("Location: doctor-login.php");
    exit();
}

$patient_id = intval($_GET['id'] ?? 0);
if ($patient_id <= 0) {
    header("Location: total-patients.php");
    exit();
}

// Fetch patient info
$patient_query = "SELECT full_name, age, phone FROM cms_patients WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $patient_query);
mysqli_stmt_bind_param($stmt, 'i', $patient_id);
mysqli_stmt_execute($stmt);
$patient_result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($patient_result);

if (!$patient) die("Patient not found.");

$patient_name  = htmlspecialchars($patient['full_name']);
$patient_age   = htmlspecialchars($patient['age']);
$patient_phone = htmlspecialchars($patient['phone']);

// Fetch appointments
$query = "SELECT a.*, p.full_name, p.age, p.phone 
          FROM cms_appointments a
          JOIN cms_patients p ON a.patient_id = p.patient_id
          WHERE a.patient_id = ?
          ORDER BY a.appointment_id DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $patient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}
$totalAppointments = count($appointments);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?= $patient_name ?> - Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: linear-gradient(135deg, #faf5ff, #ede9fe);
    font-family: 'Inter', sans-serif;
}

/* Main Wrapper */
.container-custom {
    margin-left: 250px;
    padding: 30px;
}

/* Card Header */
.page-header {
    background: linear-gradient(135deg, #c084fc, #a855f7);
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(168, 85, 247, 0.25);
    color: #fff;
    margin-bottom: 25px;
}

/* Table Card */
.table-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 12px 28px rgba(139, 92, 246, 0.15);
    border: 1px solid rgba(168, 85, 247, 0.2);
}

/* Table */
.table-modern thead {
    background: #f3e8ff;
    color: #6b21a8;
    border-bottom: 2px solid rgba(139, 92, 246, 0.3);
}

.table-modern tbody tr {
    background: #fff;
    border-radius: 12px;
    transition: all .3s ease;
}

.table-modern tbody tr:hover {
    background: #f5f3ff;
    transform: translateY(-2px);
}

.table-modern td {
    padding: 14px !important;
}

/* Status Badges */
.badge-status {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-status.approved {
    background: #d9f99d;
    color: #3f6212;
}

.badge-status.pending {
    background: #ede9fe;
    color: #6d28d9;
}

.badge-status.rejected {
    background: #fecaca;
    color: #991b1b;
}

/* Action Buttons */
.btn-action {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 6px;
    color: #fff;
    transition: 0.2s ease;
    border: none;
}

.btn-action:hover {
    transform: scale(1.1);
}

.btn-approve { background: linear-gradient(135deg, #4ade80, #22c55e); }
.btn-reject  { background: linear-gradient(135deg, #ef4444, #b91c1c); }
.btn-print   { background: linear-gradient(135deg, #c4b5fd, #8b5cf6); }

</style>
</head>

<body>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="container-custom">

    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="m-0"><?= $patient_name ?></h3>
            <small style="opacity: 0.9;">Total Appointments: <?= $totalAppointments ?></small>
        </div>
        <i class="fa-solid fa-user" style="font-size: 30px;"></i>
    </div>

    <div class="table-card">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php 
            $counter = 1;
            foreach ($appointments as $app):

                $status = strtolower($app['status']);
                $status_label = $status === 'verified' ? 'Approved' :
                                ($status === 'reject' ? 'Rejected' : 'Pending');

                $status_class = $status === 'verified' ? 'approved' :
                                ($status === 'reject' ? 'rejected' : 'pending');
            ?>
            <tr>
                <td><?= $counter++; ?></td>
                <td><strong><?= htmlspecialchars($app['full_name']) ?></strong></td>
                <td><?= htmlspecialchars($app['age']) ?></td>
                <td><?= htmlspecialchars($app['phone']) ?></td>
                <td><?= date('d-m-Y', strtotime($app['appointment_date'])) ?></td>

                <td>
                    <span class="badge-status <?= $status_class ?>"><?= $status_label ?></span>
                </td>

                <td>
                    <a href="#" class="btn-action btn-approve" title="Approve">
                        <i class="fa-solid fa-check"></i>
                    </a>

                    <a href="#" class="btn-action btn-reject" title="Reject">
                        <i class="fa-solid fa-xmark"></i>
                    </a>

                    <a href="print-prescription.php?aid=<?= $app['appointment_id'] ?>" 
                       class="btn-action btn-print" 
                       title="Print Prescription">
                       <i class="fa-solid fa-print"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>

</body>
</html>
