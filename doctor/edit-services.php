<?php
include('../includes/db_connect.php');
include('includes/header.php');
include('includes/sidebar.php');

/* VALIDATE ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid service ID");
}
$service_id = (int)$_GET['id'];

/* FETCH SERVICE */
$res = mysqli_query($conn, "SELECT * FROM cms_services WHERE service_id = $service_id LIMIT 1");
$service = mysqli_fetch_assoc($res);
if (!$service) {
    die("Service not found");
}

$success = "";

/* UPDATE */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $icon = mysqli_real_escape_string($conn, $_POST['icon']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (mysqli_query($conn,"
        UPDATE cms_services SET
          icon='$icon',
          title='$title',
          description='$description'
        WHERE service_id=$service_id
    ")) {
        $success = "Service updated successfully.";
        $service = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT * FROM cms_services WHERE service_id = $service_id")
        );
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Service</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
  font-family:'Outfit',system-ui,sans-serif;
  background:#ffffff;
  color:#111827;
}

.main-content{
  margin-left:230px;
  padding:28px;
}
@media(max-width:768px){
  .main-content{margin-left:0;padding:20px;}
}

/* CARD */
.page-card{
  max-width:900px;
  margin:auto;
  background:#fff;
  border-radius:18px;
  border:1px solid #fde2e2;
  box-shadow:0 14px 30px rgba(0,0,0,.08);
}

/* HEADER */
.page-header{
  padding:20px 26px;
  background:#fdecec;
  border-radius:18px 18px 0 0;
}
.page-header h2{
  font-size:1.15rem;
  font-weight:600;
  color:#7f1d1d;
  display:flex;
  align-items:center;
  gap:10px;
  margin:0;
}

/* BODY */
.page-body{
  padding:26px;
}

/* FORM */
.form-label{
  font-size:.85rem;
  font-weight:600;
  color:#374151;
}
.form-control{
  border-radius:12px;
  border:1px solid #fde2e2;
  font-size:.9rem;
}
.form-control:focus{
  border-color:#9f1239;
  box-shadow:0 0 0 .15rem rgba(159,18,57,.15);
}

/* BUTTON */
.btn-save{
  background:#9f1239;
  color:#fff;
  border:none;
  padding:10px 28px;
  font-size:.85rem;
  font-weight:600;
  border-radius:999px;
}
.btn-save:hover{
  background:#7f1d1d;
}

/* ALERT */
.alert{
  border-radius:12px;
  font-size:.85rem;
  border:none;
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

<div class="page-card">

  <div class="page-header">
    <h2>
      <i class="fa-solid fa-pen-to-square"></i>
      Edit Service
    </h2>
  </div>

  <div class="page-body">

    <form method="post">

      <div class="mb-3">
        <label class="form-label">Service Icon (Font Awesome class)</label>
        <input type="text" name="icon" class="form-control"
               value="<?= htmlspecialchars($service['icon']); ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Service Title</label>
        <input type="text" name="title" class="form-control"
               value="<?= htmlspecialchars($service['title']); ?>" required>
      </div>

      <div class="mb-4">
        <label class="form-label">Service Description</label>
        <textarea name="description" rows="4" class="form-control" required><?= htmlspecialchars($service['description']); ?></textarea>
      </div>

      <div class="text-end">
        <button type="submit" class="btn-save">
          <i class="fa-solid fa-save me-1"></i> Update Service
        </button>
      </div>

    </form>

  </div>
</div>
</section>

<script>
setTimeout(()=>{
  document.querySelectorAll('.auto-hide').forEach(e=>e.remove());
},1500);
</script>

</body>
</html>
