<?php
require_once('../includes/db_connect.php');
require_once('functions.php');

if (!isset($_SESSION['loginstatus_doctor'])) {
    header("Location: doctor-login.php");
    exit();
}

include('includes/sidebar.php');

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

/* COUNT */
$countRes = mysqli_query($conn,"
SELECT COUNT(*) AS total 
FROM cms_appointments
WHERE appointment_date > CURDATE()
AND appointment_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
");
$totalRecords = mysqli_fetch_assoc($countRes)['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

/* DATA */
$result = mysqli_query($conn,"
SELECT a.appointment_id, a.appointment_date, a.description, a.status,
       p.full_name, p.age, p.phone
FROM cms_appointments a
JOIN cms_patients p ON a.patient_id = p.patient_id
WHERE a.appointment_date > CURDATE()
AND a.appointment_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY a.appointment_date ASC
LIMIT $limit OFFSET $offset
");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upcoming Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
  font-family:'Outfit',sans-serif;
  background:#ffffff;
  color:#111827;
}

/* layout */
.main-wrapper{
  margin-left:245px;
  padding:28px;
}
@media(max-width:768px){
  .main-wrapper{ margin-left:0; }
}

/* card */
.appointments-card{
  background:#fff7f7;
  border-radius:18px;
  padding:22px;
  border:1px solid #fde2e2;
}

/* title */
.page-title{
  display:flex;
  align-items:center;
  gap:10px;
  font-weight:600;
  letter-spacing:.12em;
  font-size:14px;
  margin-bottom:18px;
}
.page-title i{ color:#f97316; }

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

/* status pills */
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

<div class="main-wrapper">

  <div class="appointments-card">

    <div class="page-title">
      <i class="fa-solid fa-calendar-days"></i>
      UPCOMING APPOINTMENTS · NEXT 30 DAYS
    </div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Appointment Date</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

<?php
$i = $offset + 1;
if ($result && mysqli_num_rows($result) > 0):
while ($row = mysqli_fetch_assoc($result)):
  $status = strtolower($row['status']);
  if ($status === 'verified' || $status === 'approved') {
    $cls='status-approved'; $lbl='Approved';
  } elseif ($status === 'reject' || $status === 'rejected') {
    $cls='status-rejected'; $lbl='Rejected';
  } else {
    $cls='status-pending'; $lbl='Pending';
  }
?>
<tr>
  <td><?= $i++ ?></td>
  <td class="fw-semibold"><?= htmlspecialchars($row['full_name']) ?></td>
  <td><?= $row['age'] ?></td>
  <td><?= $row['phone'] ?></td>
  <td><?= date('d M Y', strtotime($row['appointment_date'])) ?></td>
  <td><?= nl2br(htmlspecialchars($row['description'] ?? '—')) ?></td>
  <td><span class="status-pill <?= $cls ?>"><?= $lbl ?></span></td>
</tr>
<?php endwhile; else: ?>
<tr>
  <td colspan="7" class="text-center py-5 text-muted">
    No upcoming appointments found
  </td>
</tr>
<?php endif; ?>

        </tbody>
      </table>
    </div>

<?php if ($totalPages > 1): ?>
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
