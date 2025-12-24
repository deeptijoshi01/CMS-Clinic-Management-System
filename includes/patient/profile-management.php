<?php
session_start();
require_once __DIR__ . '/../../includes/db_connect.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../../patient-login.php");
    exit();
}

$patient_id = (int) $_SESSION['patient_id'];

// Fetch patient data
$query = mysqli_query($conn, "
    SELECT full_name, age, phone, email, gender, is_verify, created_at 
    FROM cms_patients 
    WHERE patient_id = '$patient_id'
    LIMIT 1
");
$patient = mysqli_fetch_assoc($query);

// Safe values
$full_name  = $patient['full_name'] ?? '';
$age        = $patient['age'] ?? '';
$phone      = $patient['phone'] ?? '';
$email      = $patient['email'] ?? '';
$gender     = $patient['gender'] ?? '';
$is_verify  = $patient['is_verify'] ?? 0;
$created_at = !empty($patient['created_at']) ? date("d M Y", strtotime($patient['created_at'])) : '-';

$patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profile Management</title>

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
}

/* ================= PROFILE CARD ================= */
.profile-card {
    max-width: 900px;
    margin: 0 auto;
    background: linear-gradient(180deg, #fffafa, #fff3f3);
    border-radius: 18px;
    padding: 26px;
    border: 1px solid #f3dcdc;
}

/* ================= HEADER ================= */
.profile-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.avatar-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #fdecec;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7a2e2e;
    font-size: 28px;
    font-weight: 600;
    text-transform: uppercase;
}

.profile-meta small {
    font-size: 12px;
    letter-spacing: 0.12em;
    color: #9a6b6b;
    font-weight: 600;
}

.profile-meta h5 {
    margin: 2px 0 4px;
    font-weight: 600;
    color: #7a2e2e;
}

.profile-meta span {
    font-size: 12px;
    color: #8b5d5d;
}

/* ================= DIVIDER ================= */
.profile-divider {
    height: 1px;
    background: #f3dcdc;
    margin: 20px 0;
}

/* ================= FORM ================= */
.profile-label {
    font-weight: 500;
    font-size: 13px;
    margin-bottom: 6px;
    color: #7a2e2e;
}

.profile-input {
    border-radius: 12px;
    padding: 10px 12px;
    border: 1px solid #f3dcdc;
}

.profile-input:focus {
    border-color: #c24141;
    box-shadow: 0 0 0 3px rgba(194, 65, 65, 0.15);
}

/* ================= BUTTON ================= */
.btn-profile-submit {
    margin-top: 20px;
    padding: 10px 22px;
    border-radius: 999px;
    background: #c24141;
    color: #ffffff;
    font-weight: 600;
    border: none;
    transition: all 0.25s ease;
}

.btn-profile-submit:hover {
    background: #9f3030;
    transform: translateY(-1px);
}

/* ================= STATUS BADGES ================= */
.badge-soft {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

.badge-soft.verified {
    background: #dcfce7;
    color: #166534;
}

.badge-soft.not-verified {
    background: #fef3c7;
    color: #92400e;
}

/* ================= ALERT ================= */
.alert {
    max-width: 900px;
    margin: 0 auto 18px;
    border-radius: 12px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 992px) {
    .patient-content {
        margin-left: 0;
        padding: 20px;
    }
}
</style>
</head>

<body>

<?php include __DIR__ . '/../header.php'; ?>
<?php include __DIR__ . '/includes/sidebar.php'; ?>

<div class="patient-content">

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">
            Profile updated successfully.
        </div>
    <?php endif; ?>

    <div class="profile-card">

        <div class="profile-header">
            <div class="avatar-circle">
                <?php echo strtoupper(substr($full_name, 0, 1)); ?>
            </div>

            <div class="profile-meta">
                <small>PATIENT PROFILE</small>
                <h5><?php echo htmlspecialchars($full_name); ?></h5>
                <span>
                    Member since <?php echo $created_at; ?> ·
                    <?php if ($is_verify == 1): ?>
                        <span class="badge-soft verified">Verified</span>
                    <?php else: ?>
                        <span class="badge-soft not-verified">Not Verified</span>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <div class="profile-divider"></div>

        <form action="profile-update.php" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="profile-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control profile-input"
                           value="<?php echo htmlspecialchars($full_name); ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="profile-label">Age</label>
                    <input type="number" name="age" class="form-control profile-input"
                           value="<?php echo htmlspecialchars($age); ?>" required>
                </div>

                <div class="col-md-3">
                    <label class="profile-label">Gender</label>
                    <select name="gender" class="form-select profile-input" required>
                        <option value="Female" <?php if ($gender === 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Male" <?php if ($gender === 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Other" <?php if ($gender === 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="profile-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control profile-input"
                           value="<?php echo htmlspecialchars($phone); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="profile-label">Email Address</label>
                    <input type="email" name="email" class="form-control profile-input"
                           value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

            </div>

            <button type="submit" class="btn btn-profile-submit mt-4">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                Save Changes
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
