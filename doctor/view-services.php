<?php
include('../includes/db_connect.php');
include('includes/header.php');
include('includes/sidebar.php');

$success = '';
$error = '';

/* DELETE SERVICE */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM cms_services WHERE service_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $success = "Service deleted successfully.";
    } else {
        $error = "Failed to delete service.";
    }
    mysqli_stmt_close($stmt);
}

/* FETCH SERVICES */
$services = [];
$res = mysqli_query($conn, "SELECT * FROM cms_services ORDER BY service_id DESC");
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) {
        $services[] = $r;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>View Services</title>
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
  max-width:1100px;
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
  display:flex;
  justify-content:space-between;
  align-items:center;
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

.btn-add{
  background:#9f1239;
  color:#fff;
  border:none;
  padding:7px 18px;
  font-size:12px;
  font-weight:600;
  border-radius:999px;
}
.btn-add:hover{
  background:#7f1d1d;
}

/* BODY */
.page-body{
  padding:26px;
}

/* SERVICE ITEM */
.service-item{
  display:flex;
  gap:18px;
  padding:16px;
  border-radius:14px;
  border:1px solid #fde2e2;
  background:#fff;
  margin-bottom:14px;
  transition:.2s;
}
.service-item:hover{
  box-shadow:0 10px 24px rgba(0,0,0,.08);
}

.service-icon{
  width:56px;
  height:56px;
  border-radius:12px;
  background:#fdecec;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#9f1239;
  font-size:24px;
}

.service-title{
  font-weight:600;
  font-size:.95rem;
}
.service-date{
  font-size:.75rem;
  color:#6b7280;
}
.service-desc{
  font-size:.85rem;
  color:#374151;
  margin-top:6px;
}

.service-actions{
  margin-left:auto;
  display:flex;
  gap:8px;
}
.action-btn{
  width:36px;
  height:36px;
  border-radius:10px;
  border:none;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#fff;
}
.btn-edit{background:#f59e0b;}
.btn-delete{background:#ef4444;}

/* ALERT */
.alert{
  border-radius:12px;
  border:none;
  font-size:.9rem;
}
</style>
</head>

<body>

<section class="main-content">

<?php if ($success): ?>
  <div class="alert alert-success text-center auto-hide"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="alert alert-danger text-center auto-hide"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="page-card">

  <div class="page-header">
    <h2><i class="fa-solid fa-hand-holding-medical"></i> Clinic Services</h2>
    <a href="<?php echo $doctorurl; ?>add-services.php" class="btn-add">
      <i class="fa-solid fa-plus me-1"></i>Add Service
    </a>
  </div>

  <div class="page-body">

    <?php if (empty($services)): ?>
      <div class="text-center text-muted py-4">
        No services added yet.
      </div>
    <?php else: ?>
      <?php foreach ($services as $s): ?>
        <div class="service-item">

          <div class="service-icon">
            <i class="<?= htmlspecialchars($s['icon']); ?>"></i>
          </div>

          <div>
            <div class="service-title"><?= htmlspecialchars($s['title']); ?></div>
            <div class="service-date"><?= date('d M Y', strtotime($s['created_at'])); ?></div>
            <div class="service-desc"><?= nl2br(htmlspecialchars($s['description'])); ?></div>
          </div>

          <div class="service-actions">
            <a href="<?= $doctorurl; ?>edit-services.php?id=<?= (int)$s['service_id']; ?>"
               class="action-btn btn-edit">
              <i class="fa-solid fa-pen"></i>
            </a>

            <form method="post" onsubmit="return confirm('Delete this service?');">
              <input type="hidden" name="delete_id" value="<?= (int)$s['service_id']; ?>">
              <button type="submit" class="action-btn btn-delete">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>

        </div>
      <?php endforeach; ?>
    <?php endif; ?>

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
