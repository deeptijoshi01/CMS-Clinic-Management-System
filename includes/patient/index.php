<?php 
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../patient-login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$pQuery = mysqli_query($conn, "SELECT full_name FROM cms_patients WHERE patient_id = '$patient_id' LIMIT 1");
$patient = mysqli_fetch_assoc($pQuery);
$patient_name = $patient['full_name'] ?? "Patient";

$tQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM cms_appointments 
    WHERE patient_id = '$patient_id'
");
$total_appointments = mysqli_fetch_assoc($tQuery)['total'] ?? 0;

$uQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS upcoming 
    FROM cms_appointments 
    WHERE patient_id = '$patient_id'
    AND appointment_date >= CURDATE()
");
$upcoming_appointments = mysqli_fetch_assoc($uQuery)['upcoming'] ?? 0;

$patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Patient Dashboard</title>

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

/* ================= NAVBAR ================= */
.navbar {
    background: #ffffff;
    border-bottom: 1px solid #f1dede;
}

.navbar-brand h1 {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.18em;
    color: #111827;
}

/* ================= MAIN ================= */
.main-wrapper {
    margin-left: 245px;
    padding: 32px;
}

/* ================= HEADER ================= */
.dashboard-title {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
}

.dashboard-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 30px;
}

/* ================= CARD GRID ================= */
.card-grid {
    row-gap: 24px;
}

/* ================= DASH CARDS ================= */
.dash-card {
    background: linear-gradient(180deg, #fffafa, #fff3f3);
    border: 1px solid #f3dcdc;
    border-radius: 16px;
    padding: 22px;
    height: 100%;
    transition: all 0.25s ease;
    position: relative;
}

.dash-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: #f2b6b6;
    border-radius: 16px 0 0 16px;
}

.dash-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(0,0,0,0.08);
    border-color: #e9caca;
}

.dash-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}

.dash-card-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}

.dash-card-title i {
    color: #c24141;
}

.dash-card-tag {
    font-size: 11px;
    background: #fdecec;
    padding: 4px 10px;
    border-radius: 999px;
    color: #7a2e2e;
}

.dash-card-value {
    font-size: 26px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 4px;
}

.dash-card-label {
    font-size: 13px;
    color: #6b7280;
}

.dash-card-link {
    display: inline-block;
    margin-top: 12px;
    font-size: 13px;
    font-weight: 500;
    color: #7a2e2e;
}

/* ================= LINKS ================= */
a { color: inherit; }
a:hover { text-decoration: none; }

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .main-wrapper {
        margin-left: 0;
        padding: 20px;
    }
}

@media (max-width: 576px) {
    .dashboard-title {
        font-size: 18px;
    }

    .dash-card {
        padding: 18px;
    }

    .dash-card-value {
        font-size: 22px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $patienturl; ?>index.php">
            <h1>PATIENT</h1>
        </a>

        <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-pill">
            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
        </a>
    </div>
</nav>

<!-- SIDEBAR -->
<?php include('includes/sidebar.php'); ?>

<!-- CONTENT -->
<div class="main-wrapper">

    <div class="dashboard-title">Patient Overview</div>
    <div class="dashboard-subtitle">
        Summary of your profile and appointment activity
    </div>

    <div class="row card-grid">

        <div class="col-lg-4 col-md-6">
            <a href="<?php echo $patienturl; ?>profile-management.php">
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div class="dash-card-title">
                            <i class="fa-solid fa-user"></i> Patient Name
                        </div>
                        <span class="dash-card-tag">Profile</span>
                    </div>
                    <div class="dash-card-value"><?php echo htmlspecialchars($patient_name); ?></div>
                    <div class="dash-card-label">View and update your details</div>
                    <span class="dash-card-link">View profile →</span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="<?php echo $patienturl; ?>total-appointments.php">
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div class="dash-card-title">
                            <i class="fa-solid fa-calendar-check"></i> Total Appointments
                        </div>
                        <span class="dash-card-tag">History</span>
                    </div>
                    <div class="dash-card-value"><?php echo $total_appointments; ?></div>
                    <div class="dash-card-label">All appointments booked</div>
                    <span class="dash-card-link">View appointments →</span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-12">
            <a href="<?php echo $patienturl; ?>upcoming-appointments.php">
                <div class="dash-card">
                    <div class="dash-card-header">
                        <div class="dash-card-title">
                            <i class="fa-solid fa-calendar-days"></i> Upcoming Appointments
                        </div>
                        <span class="dash-card-tag">Schedule</span>
                    </div>
                    <div class="dash-card-value"><?php echo $upcoming_appointments; ?></div>
                    <div class="dash-card-label">Scheduled & pending visits</div>
                    <span class="dash-card-link">View schedule →</span>
                </div>
            </a>
        </div>

    </div>
</div>

</body>
</html>
