<?php
include('includes/header.php');
include('includes/sidebar.php');
include('../includes/db_connect.php');

/* DELETE IMAGE */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $q = mysqli_query($conn, "SELECT slider_image FROM cms_slider WHERE slider_id = $id");
    $r = mysqli_fetch_assoc($q);

    if ($r) {
        $file = realpath(__DIR__ . '/../uploads') . DIRECTORY_SEPARATOR . $r['slider_image'];
        if (file_exists($file)) @unlink($file);
        mysqli_query($conn, "DELETE FROM cms_slider WHERE slider_id = $id");
        header("Location: manage-slider-images.php?deleted=1");
        exit;
    }
}

/* FETCH IMAGES */
$slider = mysqli_query($conn, "SELECT * FROM cms_slider ORDER BY slider_id DESC");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Slider Images</title>
<meta name="viewport" content="width=device-width,initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ================= BASE ================= */
body{
  font-family:'Outfit',sans-serif;
  background:#ffffff;
  color:#111827;
}

.main-content{
  margin-left:230px;
  padding:28px;
}
@media(max-width:768px){
  .main-content{margin-left:0}
}

/* ================= CARD ================= */
.card-box{
  max-width:1100px;
  margin:auto;
  background:#ffffff;
  border-radius:18px;
  border:1px solid #fde2e2;
  box-shadow:0 14px 30px rgba(0,0,0,.08);
  overflow:hidden; /* 🔥 IMPORTANT FIX */
}

.card-header{
  background:#fdecec;
  padding:20px 26px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.card-header h2{
  margin:0;
  font-size:1.1rem;
  font-weight:600;
  color:#7f1d1d;
  display:flex;
  gap:10px;
  align-items:center;
}

.btn-add{
  background:#9f1239;
  color:#fff;
  border:none;
  padding:9px 16px;
  border-radius:999px;
  font-size:.8rem;
  font-weight:600;
}
.btn-add:hover{background:#7f1d1d}

.card-body{padding:26px}

/* ================= TABLE ================= */
.table{
  margin-bottom:0;
}

.table th{
  font-size:.75rem;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:#6b7280;
  border-bottom:1px solid #fde2e2;
}

.table td{
  vertical-align:middle;
  border-bottom:1px solid #fdecec;
  font-size:.85rem;
}

/* 🔥 IMAGE SIZE FIX */
.slider-img{
  width:160px;
  height:92px;
  max-width:100%;
  max-height:92px;
  object-fit:cover;
  border-radius:12px;
  border:1px solid #fde2e2;
  cursor:pointer;
  display:block;
}

/* ================= ACTION ================= */
.btn-delete{
  background:#fee2e2;
  color:#991b1b;
  border:none;
  padding:8px 10px;
  border-radius:10px;
}
.btn-delete:hover{
  background:#fecaca;
}

/* ================= ALERT ================= */
.alert{
  border-radius:12px;
  font-size:.85rem;
  border:none;
}
</style>
</head>

<body>

<section class="main-content">
<div class="card-box">

  <div class="card-header">
    <h2><i class="fa-solid fa-images"></i> Slider Images</h2>
    <a href="add-slider-image.php" class="btn-add">
      <i class="fa-solid fa-plus me-1"></i> Add Image
    </a>
  </div>

  <div class="card-body">

    <?php if (isset($_GET['deleted'])): ?>
      <div class="alert alert-success auto-hide">
        Image deleted successfully
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Uploaded On</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        <?php $i=1; while($row=mysqli_fetch_assoc($slider)): ?>
        <tr>
          <td><?= $i++; ?></td>

          <td class="text-center">
            <img src="../uploads/<?= htmlspecialchars($row['slider_image']); ?>"
                 class="slider-img"
                 data-bs-toggle="modal"
                 data-bs-target="#previewModal"
                 onclick="showPreview('../uploads/<?= htmlspecialchars($row['slider_image']); ?>')">
          </td>

          <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>

          <td>
            <a href="?delete=<?= $row['slider_id']; ?>"
               class="btn-delete"
               onclick="return confirm('Delete this image?')">
              <i class="fa-solid fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php endwhile; ?>

        </tbody>
      </table>
    </div>

  </div>
</div>
</section>

<!-- ================= PREVIEW MODAL ================= -->
<div class="modal fade" id="previewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-0">
        <h6 class="modal-title">Image Preview</h6>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="previewImg"
             class="img-fluid rounded"
             style="max-height:480px;width:auto;">
      </div>
    </div>
  </div>
</div>

<script>
function showPreview(src){
  document.getElementById('previewImg').src = src;
}
setTimeout(()=>{
  document.querySelectorAll('.auto-hide').forEach(e=>e.remove())
},1500);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
