<?php
include('../includes/db_connect.php');
include('includes/header.php');
include('includes/sidebar.php');

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_service') {
    $icon = trim($_POST['icon'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($icon === '' || $title === '' || $description === '') {
        $errors[] = "All fields are required.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO cms_services (icon, title, description, created_at) VALUES (?, ?, ?, NOW())"
        );
        mysqli_stmt_bind_param($stmt, "sss", $icon, $title, $description);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Service added successfully.";
            $_POST = [];
        } else {
            $errors[] = "Database error occurred.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Service</title>
<meta name="viewport" content="width=device-width,initial-scale=1">

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
.service-card{
  max-width:820px;
  margin:auto;
  background:#fff;
  border-radius:18px;
  border:1px solid var(--border-soft);
  box-shadow:0 18px 35px rgba(0,0,0,.08);
}

/* HEADER */
.service-header{
  padding:22px 26px;
  background:var(--accent-soft);
  border-radius:18px 18px 0 0;
}
.service-header h2{
  margin:0;
  font-size:1.25rem;
  font-weight:600;
  color:#7f1d1d;
  display:flex;
  align-items:center;
  gap:10px;
}

/* BODY */
.service-body{padding:26px;}

.form-label{
  font-weight:600;
  font-size:.9rem;
  color:#374151;
}

/* INPUTS */
.form-control,
textarea{
  border-radius:12px;
  border:1px solid var(--border-soft);
  font-size:.9rem;
}
.form-control:focus,
textarea:focus{
  border-color:var(--accent);
  box-shadow:0 0 0 .15rem rgba(159,18,57,.15);
}

/* ICON INPUT */
.input-icon{
  position:relative;
}
.input-icon i{
  position:absolute;
  top:50%;
  left:14px;
  transform:translateY(-50%);
  color:#9f1239;
}
.input-icon .form-control{
  padding-left:42px;
}

/* FOOTER */
.service-footer{
  padding:18px 26px;
  background:#fffafa;
  border-radius:0 0 18px 18px;
}

/* BUTTON */
.btn-submit{
  background:#9f1239;
  color:#fff;
  border:none;
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

/* ALERT */
.alert{
  border-radius:14px;
  border:none;
  font-size:.9rem;
}
.note{
  font-size:12px;
  color:#6b7280;
}
</style>
</head>

<body>

<section class="main-content">

<?php if ($success): ?>
  <div class="alert alert-success text-center auto-hide">
    <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($success) ?>
  </div>
<?php endif; ?>

<?php if ($errors): ?>
  <div class="alert alert-danger auto-hide">
    <?php foreach ($errors as $e): ?>
      <?= htmlspecialchars($e) ?><br>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="service-card">

  <div class="service-header">
    <h2><i class="fa-solid fa-plus"></i> Add New Service</h2>
  </div>

  <form method="post">
    <input type="hidden" name="action" value="add_service">

    <div class="service-body">

      <div class="mb-3">
        <label class="form-label">Service Icon (Font Awesome)</label>
        <div class="input-icon">
          <i class="fa-solid fa-icons"></i>
          <input type="text" name="icon" class="form-control"
                 placeholder="fa-solid fa-tooth"
                 value="<?= htmlspecialchars($_POST['icon'] ?? '') ?>" required>
        </div>
        <div class="note mt-1">
          Example: fa-solid fa-tooth (from fontawesome.com)
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Service Title</label>
        <input type="text" name="title" class="form-control"
               placeholder="Dental Checkup"
               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Service Description</label>
        <textarea name="description" rows="5" class="form-control" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

    </div>

    <div class="service-footer text-end">
      <button type="submit" class="btn-submit">
        <i class="fa-solid fa-paper-plane me-2"></i>Add Service
      </button>
    </div>

  </form>
</div>
</section>

<script>
setTimeout(()=>{
  document.querySelectorAll('.auto-hide').forEach(e=>e.remove());
},1800);
</script>

</body>
</html>
  