<?php
// edit-appointment.php
// Style B - Purple theme edit form for appointments
// Allows editing only: appointment_date, description, status
// Uses prepared statements and smart redirect back to source page.

// No login check here (follow your app's approach)
require_once('../includes/db_connect.php');
require_once('functions.php');

// ------------------ Helpers ------------------
// Whitelist of valid source pages to avoid open-redirects
$allowed_sources = [
    'total-appointments.php',
    'todays-appointments.php',
    'upcoming-appointments.php'
];

// Read GET params
$aid = intval($_GET['aid'] ?? 0);
$source = basename($_GET['source'] ?? ''); // basename for safety

// Fallback source
if (!in_array($source, $allowed_sources, true)) {
    $source = 'total-appointments.php';
}

// Validate appointment id
if ($aid <= 0) {
    // Could redirect back with an error, but simple die() for now
    die("Invalid appointment ID.");
}

// Fetch appointment with patient details
$sql = "SELECT a.*, p.full_name, p.age, p.phone 
        FROM cms_appointments a
        INNER JOIN cms_patients p ON a.patient_id = p.patient_id
        WHERE a.appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aid);
$stmt->execute();
$res = $stmt->get_result();
$app = $res->fetch_assoc();

if (!$app) {
    die("Appointment not found.");
}

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    // sanitize inputs
    $appointment_date = trim($_POST['appointment_date'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // basic validation
    if ($appointment_date === '') {
        $errors[] = "Appointment date is required.";
    } else {
        // server-side date check (YYYY-MM-DD)
        $d = DateTime::createFromFormat('Y-m-d', $appointment_date);
        if (!($d && $d->format('Y-m-d') === $appointment_date)) {
            $errors[] = "Invalid appointment date format.";
        }
    }

    $allowed_statuses = ['pending', 'verified', 'reject'];
    if (!in_array($status, $allowed_statuses, true)) {
        $errors[] = "Invalid status selected.";
    }

    if (empty($errors)) {
        $update_sql = "UPDATE cms_appointments 
                       SET appointment_date = ?, description = ?, status = ?
                       WHERE appointment_id = ?";
        $up = $conn->prepare($update_sql);
        $up->bind_param("sssi", $appointment_date, $description, $status, $aid);

        if ($up->execute()) {
            // Redirect back to same source with a success flag
            header("Location: {$source}?updated=1");
            exit();
        } else {
            $errors[] = "Database error while updating. Please try again.";
        }
    }
}

// --- Page HTML below ---
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Appointment</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family:'Poppins',sans-serif; background:#faf8ff; }
    .main-wrapper { margin-left:270px; padding:28px; }
    .card-glass {
      max-width:900px; margin:28px auto; padding:26px;
      border-radius:20px; background:linear-gradient(135deg,#ffffffcc,#f3ecffcc);
      box-shadow:0 22px 50px rgba(139,92,246,0.12); border:1px solid rgba(179,153,255,0.25);
    }
    .card-header-title { font-size:22px; font-weight:700; color:#5b2ea6; display:flex; gap:12px; align-items:center; }
    label { font-weight:600; color:#4c1d95; }
    .form-control, .form-select { border-radius:10px; padding:10px 12px; }
    .btn-primary-custom {
      background: linear-gradient(135deg,#8b5cf6,#6f42c1);
      border: none; color: #fff; padding:10px 18px; border-radius:10px;
      box-shadow: 0 10px 25px rgba(139,92,246,0.18);
    }
    .btn-secondary-light {
      background:#f3f3ff; border:1px solid rgba(139,92,246,0.08); color:#4c1d95;
    }
    .small-muted { color:#6f5497; font-size:13px; }
    .error-list { color:#b91c1c; }
  </style>
</head>
<body>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="main-wrapper">
  <div class="card-glass">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="card-header-title"><i class="fa-solid fa-pen-to-square" style="color:#8b5cf6;"></i>Edit Appointment</div>
      <div class="small-muted">Editing appointment #<?= htmlspecialchars($app['appointment_id']); ?></div>
    </div>

    <!-- Errors -->
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0 error-list">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="row g-3">
        <div class="col-md-6">
          <label>Patient Name</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($app['full_name']); ?>" readonly>
        </div>

        <div class="col-md-3">
          <label>Age</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($app['age']); ?>" readonly>
        </div>

        <div class="col-md-3">
          <label>Phone</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($app['phone']); ?>" readonly>
        </div>

        <div class="col-md-4">
          <label>Appointment Date</label>
          <input type="date" name="appointment_date" class="form-control" required
                 value="<?= htmlspecialchars(date('Y-m-d', strtotime($app['appointment_date']))); ?>">
        </div>

        <div class="col-md-8">
          <label>Description</label>
          <input type="text" name="description" class="form-control"
                 value="<?= htmlspecialchars($app['description'] ?? ''); ?>" placeholder="Short description / symptoms">
        </div>

        <div class="col-md-4">
          <label>Status</label>
          <select name="status" class="form-select" required>
            <option value="pending" <?= ($app['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="verified" <?= ($app['status'] === 'verified') ? 'selected' : '' ?>>Verified</option>
            <option value="reject" <?= ($app['status'] === 'reject') ? 'selected' : '' ?>>Rejected</option>
          </select>
        </div>

      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="<?= htmlspecialchars($source); ?>" class="btn btn-secondary btn-secondary-light">Cancel</a>

        <!-- Hidden fields to preserve source & aid if needed -->
        <input type="hidden" name="source" value="<?= htmlspecialchars($source); ?>">
        <input type="hidden" name="aid" value="<?= intval($aid); ?>">

        <button type="submit" name="update" class="btn btn-primary btn-primary-custom">
          <i class="fa-solid fa-floppy-disk me-2"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
