<?php
session_start();
require_once('../includes/db_connect.php');

if (!isset($_SESSION['loginstatus_doctor'])) {
    header("Location: doctor-login.php");
    exit();
}

/* PAGINATION */
$limit = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

/* TOTAL */
$countQ = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cms_appointments");
$totalRecords = mysqli_fetch_assoc($countQ)['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

/* DATA */
$query = mysqli_query($conn, "
  SELECT a.appointment_id, a.appointment_date, a.status, a.create_at, p.full_name
  FROM cms_appointments a
  JOIN cms_patients p ON p.patient_id = a.patient_id
  ORDER BY a.appointment_id DESC
  LIMIT $limit OFFSET $offset
");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Total Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
  font-family:'Outfit',sans-serif;
  background:#fff;
  color:#111827;
}

/* layout */
.main-wrapper{ margin-left:245px; padding:28px; }
@media(max-width:768px){ .main-wrapper{margin-left:0;} }

/* card */
.appointments-card{
  background:#fff7f7;
  border-radius:18px;
  padding:22px;
  border:1px solid #fde2e2;
}

/* header */
.page-title{
  display:flex;
  align-items:center;
  gap:10px;
  font-weight:600;
  letter-spacing:.12em;
  font-size:14px;
  margin-bottom:18px;
}
.page-title i{ color:#ef4444; }

/* table */
.table thead th{
  font-size:12px;
  text-transform:uppercase;
  letter-spacing:.06em;
  color:#374151;
}
.table td{
  font-size:14px;
  vertical-align:middle;
}

/* status */
.status-pill{
  padding:6px 14px;
  border-radius:999px;
  font-size:12px;
  font-weight:600;
}
.status-approved{ background:#dcfce7; color:#166534; }
.status-pending{ background:#fef3c7; color:#92400e; }
.status-rejected{ background:#fee2e2; color:#991b1b; }

/* pagination */
.pagination .page-link{
  border-radius:999px;
  font-size:13px;
  border:1px solid #ddd;
  color:#111;
}
.pagination .active .page-link{
  background:#111;
  border-color:#111;
  color:#fff;
}
</style>
</head>

<body>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="main-wrapper">

  <div class="appointments-card">

    <div class="page-title">
      <i class="fa-solid fa-calendar-check"></i>
      TOTAL APPOINTMENTS
    </div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Booking Date</th>
            <th>Appointment Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

<?php
if ($query && mysqli_num_rows($query) > 0) {
  $i = $offset + 1;
  while ($row = mysqli_fetch_assoc($query)) {

    $status = strtolower($row['status']);
    if ($status === 'verified' || $status === 'approved') {
      $cls = 'status-approved'; $lbl = 'Approved';
    } elseif ($status === 'rejected') {
      $cls = 'status-rejected'; $lbl = 'Rejected';
    } else {
      $cls = 'status-pending'; $lbl = 'Pending';
    }

    echo "
    <tr>
      <td>{$i}</td>
      <td>{$row['full_name']}</td>
      <td>".date('d M Y',strtotime($row['create_at']))."</td>
      <td>".date('d M Y',strtotime($row['appointment_date']))."</td>
      <td><span class='status-pill {$cls}'>{$lbl}</span></td>
    </tr>";
    $i++;
  }
} else {
  echo "
  <tr>
    <td colspan='5' class='text-center py-5 text-muted'>
      No appointments found
    </td>
  </tr>";
}
?>

        </tbody>
      </table>
    </div>

<?php if($totalPages>1): ?>
<nav class="mt-4">
  <ul class="pagination justify-content-center">
<?php for($p=1;$p<=$totalPages;$p++): ?>
    <li class="page-item <?=($p==$page)?'active':''?>">
      <a class="page-link" href="?page=<?=$p?>"><?=$p?></a>
    </li>
<?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
