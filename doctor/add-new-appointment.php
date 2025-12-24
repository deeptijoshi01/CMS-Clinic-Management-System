<?php 
include('../includes/db_connect.php'); 
include('functions.php');
include('includes/header.php'); 
include('includes/sidebar.php'); 

$doctorurl = "http://localhost/CMS-NEW/doctor/";

$addRes = "";
if (isset($_POST['submit'])) {
    if (isset($_POST['patient_id'])) {
        $_POST['patient_id'] = intval($_POST['patient_id']);
    }
    $addRes = add_appointment($conn, $_POST);
}

$edit_patient = null;
if (isset($_GET['pid'])) {
    $pid = intval($_GET['pid']);
    if ($pid > 0) {
        $edit_patient = fetch_single_patient($conn, $pid);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Appointment</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --accent:#9f1239;
  --accent-soft:#fdecec;
  --border-soft:#fde2e2;
  --text-main:#111827;
}

/* PAGE */
body{
  background:#ffffff;
  font-family:'Outfit',system-ui,sans-serif;
  color:var(--text-main);
}

/* LAYOUT */
.main-content{
  margin-left:230px;
  padding:28px;
}
@media(max-width:768px){
  .main-content{margin-left:0;padding:20px;}
}

/* CARD */
.appointment-card{
  max-width:900px;
  margin:auto;
  background:#fff;
  border-radius:18px;
  border:1px solid var(--border-soft);
  box-shadow:0 18px 35px rgba(0,0,0,.08);
}

/* HEADER */
.appointment-header{
  padding:22px 26px;
  background:var(--accent-soft);
  border-radius:18px 18px 0 0;
}
.appointment-header h2{
  margin:0;
  font-size:1.25rem;
  font-weight:600;
  color:#7f1d1d;
}

/* BODY */
.appointment-body{padding:26px;}
.form-label{
  font-weight:600;
  font-size:.9rem;
  color:#374151;
}

/* INPUTS */
.form-control,
.form-select,
textarea{
  border-radius:12px;
  border:1px solid var(--border-soft);
  font-size:.9rem;
}
.form-control:focus,
.form-select:focus,
textarea:focus{
  border-color:var(--accent);
  box-shadow:0 0 0 .15rem rgba(159,18,57,.15);
}

/* FOOTER */
.appointment-footer{
  padding:18px 26px;
  background:#fffafa;
  border-radius:0 0 18px 18px;
  text-align:right;
}

/* BUTTON */
.btn-submit{
  background:#9f1239;
  border:none;
  color:#fff;
  padding:10px 26px;
  border-radius:999px;
  font-weight:600;
  font-size:.85rem;
  transition:.25s;
}
.btn-submit:hover{
  background:#7f1d1d;
  transform:translateY(-2px);
}

/* ALERTS */
.alert{
  border-radius:14px;
  border:none;
  font-size:.9rem;
}
</style>
</head>

<body>

<div class="main-content">

<?php if (!empty($addRes)): ?>
  <div class="alert <?= $addRes=='APPOINTMENT BOOKED SUCCESSFULLY'?'alert-success':'alert-danger' ?> text-center auto-hide">
    <?= htmlspecialchars($addRes) ?>
  </div>
<?php endif; ?>

<div class="appointment-card">

  <div class="appointment-header">
    <h2><i class="fa-solid fa-calendar-plus me-2"></i>Add New Appointment</h2>
  </div>

  <form method="post">

  <div class="appointment-body">
    <div class="row g-3">

      <div class="col-md-8">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control"
          value="<?= htmlspecialchars($edit_patient['full_name'] ?? '') ?>"
          <?= $edit_patient?'readonly':'' ?> required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control"
          value="<?= htmlspecialchars($edit_patient['age'] ?? '') ?>"
          <?= $edit_patient?'readonly':'' ?> required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="tel" name="phone" class="form-control"
          value="<?= htmlspecialchars($edit_patient['phone'] ?? '') ?>"
          <?= $edit_patient?'readonly':'' ?> required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
          value="<?= htmlspecialchars($edit_patient['email'] ?? '') ?>"
          <?= $edit_patient?'readonly':'' ?>>
      </div>

      <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" <?= $edit_patient?'disabled':'' ?> required>
          <option value="">Select Gender</option>
          <option value="Male" <?= (($edit_patient['gender']??'')=='Male')?'selected':'' ?>>Male</option>
          <option value="Female" <?= (($edit_patient['gender']??'')=='Female')?'selected':'' ?>>Female</option>
          <option value="Other" <?= (($edit_patient['gender']??'')=='Other')?'selected':'' ?>>Other</option>
        </select>
        <?php if($edit_patient): ?>
          <input type="hidden" name="gender" value="<?= htmlspecialchars($edit_patient['gender']) ?>">
        <?php endif; ?>
      </div>

      <div class="col-md-6">
        <label class="form-label">Appointment Date</label>
        <input type="date" name="appointment_date" class="form-control" required min="<?= date('Y-m-d') ?>">
      </div>

      <div class="col-12">
        <label class="form-label">Describe the Issue</label>
        <textarea name="description" rows="4" class="form-control" required></textarea>
      </div>

    </div>
  </div>

  <div class="appointment-footer">
    <?php if($edit_patient): ?>
      <input type="hidden" name="patient_id" value="<?= $edit_patient['patient_id'] ?>">
    <?php endif; ?>

    <button type="submit" name="submit" class="btn-submit">
      <i class="fa-solid fa-calendar-check me-2"></i>Book Appointment
    </button>
  </div>

  </form>
</div>
</div>

<script>
document.querySelectorAll('.auto-hide').forEach(a=>{
  setTimeout(()=>a.style.display='none',1600);
});
</script>

</body>
</html>
