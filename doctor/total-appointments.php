<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once('../includes/db_connect.php');
require_once('functions.php');

if (!isset($_SESSION['loginstatus_doctor'])) {
    header("Location: doctor-login.php");
    exit();
}

include('includes/header.php');
include('includes/sidebar.php');

/* PAGINATION */
$limit = 7;
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = max(1, $page);
$offset = ($page - 1) * $limit;

$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cms_appointments");
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages   = ceil($totalRecords / $limit);

$result = mysqli_query(
    $conn,
    "SELECT 
        a.appointment_id,
        a.appointment_date,
        a.description,
        a.status,
        p.full_name,
        p.age,
        p.phone
    FROM cms_appointments a
    INNER JOIN cms_patients p 
        ON a.patient_id = p.patient_id
    ORDER BY a.appointment_id DESC
    LIMIT $limit OFFSET $offset"
);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Total Appointments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.content-wrapper{
    margin-left:245px;
    padding:25px;
}

.outer-box {
    background:#FFECEC;
    border-radius:18px;
    padding:30px;
    border:1px solid #f0caca;
}

.heading-text{
    font-size:22px;
    font-weight:600;
    color:#444;
    margin-bottom:25px;
}

.table-container{
    background:white;
    border-radius:14px;
    padding:20px;
}

.badge{
    font-size:12px;
    padding:6px 10px;
    border-radius:10px;
}

.pagination .page-link{
    border-radius:8px;
}
</style>
</head>

<body>

<div class="content-wrapper">

    <div class="outer-box shadow-sm">
        <div class="heading-text">
            TOTAL APPOINTMENTS
        </div>

        <div class="table-container">

            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Date</th>
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

                        if($status === 'verified'){
                            $label = '<span class="badge bg-success">Approved</span>';
                        }
                        elseif($status === 'reject'){
                            $label = '<span class="badge bg-danger">Rejected</span>';
                        }
                        else{
                            $label = '<span class="badge bg-warning text-dark">Pending</span>';
                        }
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['full_name']); ?></td>
                        <td><?= htmlspecialchars($row['age']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['appointment_date'])); ?></td>
                        <td><?= nl2br(htmlspecialchars($row['description'] ?? '—')); ?></td>
                        <td><?= $label; ?></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="7" class="py-3 fw-bold text-danger">
                            No appointments found
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

        </div>

        <?php if($totalPages > 1): ?>
        <div class="mt-3">
            <nav>
                <ul class="pagination justify-content-center">

                    <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>

                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <li class="page-item <?= ($p == $page ? 'active' : '') ?>">
                            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>

                </ul>
            </nav>
        </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
