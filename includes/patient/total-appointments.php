<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../patient-login.php");
    exit();
}

$patient_id = (int) $_SESSION['patient_id'];

/* PAGINATION */
$limit = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

/* TOTAL RECORDS */
$countQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM cms_appointments 
    WHERE patient_id = '$patient_id'
");
$totalRecords = mysqli_fetch_assoc($countQuery)['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

/* FETCH RECORDS */
$query = mysqli_query($conn, "
    SELECT appointment_id, appointment_date, status, create_at
    FROM cms_appointments
    WHERE patient_id = '$patient_id'
    ORDER BY appointment_id DESC
    LIMIT $limit OFFSET $offset
");

$patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Total Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* ================= BASE ================= */
body {
    font-family: 'Inter', sans-serif;
    background: #ffffff;
    margin: 0;
    color: #1f2937;
}

/* ================= LAYOUT ================= */
.patient-content {
    margin-left: 245px;
    padding: 28px;
    width: 100%;
}

/* ================= CARD ================= */
.appointments-card {
    background: linear-gradient(180deg, #fffafa, #fff3f3);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #f3dcdc;
}

/* ================= HEADER ================= */
.appointments-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 20px;
}

.appointments-title {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.12em;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #7a2e2e;
}

.appointments-title i {
    color: #c24141;
}

.appointments-meta {
    font-size: 12px;
    color: #8b5d5d;
    text-align: right;
}

/* ================= TABLE ================= */
.table-modern {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #f3dcdc;
}

.table-modern thead {
    background: #fff1f1;
}

.table-modern th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #7a2e2e;
    white-space: nowrap;
}

.table-modern td {
    font-size: 14px;
    vertical-align: middle;
    white-space: nowrap;
    color: #374151;
}

/* ================= STATUS BADGES ================= */
.badge-status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-status.approved {
    background: #dcfce7;
    color: #166534;
}

.badge-status.pending {
    background: #fef3c7;
    color: #92400e;
}

.badge-status.rejected {
    background: #fee2e2;
    color: #991b1b;
}

/* ================= PAGINATION ================= */
.pagination {
    flex-wrap: wrap;
}

.pagination .page-link {
    border-radius: 999px;
    border: 1px solid #f3dcdc;
    background: #fffafa;
    color: #7a2e2e;
    font-size: 13px;
    margin: 3px;
}

.pagination .page-item.active .page-link {
    background: #c24141;
    border-color: #c24141;
    color: #ffffff;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .patient-content {
        margin-left: 0;
        padding: 20px;
    }
}

@media (max-width: 576px) {
    .appointments-card {
        padding: 18px;
    }

    .appointments-title {
        font-size: 14px;
        letter-spacing: 0.08em;
    }

    .appointments-meta {
        font-size: 11px;
        text-align: left;
    }
}
</style>
</head>

<body>

<?php include __DIR__ . '/../header.php'; ?>
<?php include __DIR__ . '/includes/sidebar.php'; ?>

<div class="patient-content">

    <div class="appointments-card">

        <div class="appointments-header">
            <div class="appointments-title">
                <i class="fa-solid fa-calendar-check"></i>
                TOTAL APPOINTMENTS
            </div>
            <div class="appointments-meta">
                Today · <?php echo date("d M Y"); ?><br>
                Showing latest bookings
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
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
                        if ($status === 'verified') {
                            $class = 'approved'; $label = 'Approved';
                        } elseif ($status === 'rejected' || $status === 'reject') {
                            $class = 'rejected'; $label = 'Rejected';
                        } else {
                            $class = 'pending'; $label = 'Pending';
                        }

                        $bookingDate = $row['create_at'] ? date("d M Y", strtotime($row['create_at'])) : '-';
                        $apptDate = $row['appointment_date'] ? date("d M Y", strtotime($row['appointment_date'])) : '-';

                        echo "
                        <tr>
                            <td>$i</td>
                            <td>$bookingDate</td>
                            <td>$apptDate</td>
                            <td><span class='badge-status $class'>$label</span></td>
                        </tr>";
                        $i++;
                    }
                } else {
                    echo "
                    <tr>
                        <td colspan='4' class='text-center py-5'>
                            <i class='fa-solid fa-calendar-xmark' style='font-size:2.5rem;color:#e5b4b4;'></i>
                            <p class='mt-2 text-muted'>No appointments found</p>
                        </td>
                    </tr>";
                }
                ?>

                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center mb-0">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $p; ?>">
                            <?php echo $p; ?>
                        </a>
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
