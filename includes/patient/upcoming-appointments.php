<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../patient-login.php");
    exit();
}

$patient_id = (int) $_SESSION['patient_id'];

// FETCH UPCOMING APPOINTMENTS
$query = "
    SELECT appointment_id, appointment_date, status
    FROM cms_appointments
    WHERE patient_id = '$patient_id'
      AND appointment_date >= CURDATE()
    ORDER BY appointment_date ASC
";
$result = mysqli_query($conn, $query);

$patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upcoming Appointments</title>

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
.upcoming-card {
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

/* ================= EMPTY STATE ================= */
.no-appointments {
    text-align: center;
    padding: 50px 20px;
    color: #9a6b6b;
}

.no-appointments i {
    font-size: 2.8rem;
    margin-bottom: 12px;
    color: #e5b4b4;
}

.no-appointments h5 {
    font-weight: 600;
    color: #7a2e2e;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .patient-content {
        margin-left: 0;
        padding: 20px;
    }

    .appointments-meta {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .upcoming-card {
        padding: 18px;
    }

    .appointments-title {
        font-size: 14px;
        letter-spacing: 0.08em;
    }
}
</style>
</head>

<body>

<?php include __DIR__ . '/../header.php'; ?>
<?php include __DIR__ . '/includes/sidebar.php'; ?>

<div class="patient-content">

    <div class="upcoming-card">

        <div class="appointments-header">
            <div class="appointments-title">
                <i class="fa-solid fa-calendar-days"></i>
                UPCOMING APPOINTMENTS
            </div>
            <div class="appointments-meta">
                Next 30 days<br>
                <small>
                    You have <?php echo ($result ? mysqli_num_rows($result) : 0); ?> upcoming bookings
                </small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                if ($result && mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                        $status = strtolower($row['status']);
                        if ($status === 'verified') {
                            $class = 'approved'; $label = 'Approved';
                        } elseif ($status === 'rejected' || $status === 'reject') {
                            $class = 'rejected'; $label = 'Rejected';
                        } else {
                            $class = 'pending'; $label = 'Pending';
                        }

                        $apptDate = date("d M Y", strtotime($row['appointment_date']));
                        ?>

                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($apptDate); ?></td>
                            <td><span class="badge-status <?php echo $class; ?>"><?php echo $label; ?></span></td>
                        </tr>

                        <?php
                    }

                } else {
                ?>

                <tr>
                    <td colspan="3">
                        <div class="no-appointments">
                            <i class="fa-solid fa-calendar-xmark"></i>
                            <h5>No upcoming appointments</h5>
                            <p class="mb-0">You’re all set. Book your next visit when needed.</p>
                        </div>
                    </td>
                </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
