<?php
// ================= DELETE IMAGE (RUN FIRST) =================
if (isset($_GET['delete'])) {
    require_once('../includes/db_connect.php');

    $id = (int)$_GET['delete'];
    $q = mysqli_query($conn, "SELECT slider_image FROM cms_slider WHERE slider_id = $id");
    $row = mysqli_fetch_assoc($q);

    if ($row) {
        $file = "../uploads/" . $row['slider_image'];
        if (file_exists($file)) unlink($file);
        mysqli_query($conn, "DELETE FROM cms_slider WHERE slider_id = $id");
    }
    header("Location: add-slider-image.php?deleted=1");
    exit;
}

include('../includes/db_connect.php');
include('includes/header.php');
include('includes/sidebar.php');

/* RESIZE */
function resizeAndCrop($src,$dest,$tw=1920,$th=1080){
    [$w,$h,$t]=getimagesize($src);
    if($t==IMAGETYPE_JPEG)$i=imagecreatefromjpeg($src);
    elseif($t==IMAGETYPE_PNG)$i=imagecreatefrompng($src);
    elseif($t==IMAGETYPE_WEBP)$i=imagecreatefromwebp($src);
    else return false;

    $s=max($tw/$w,$th/$h);
    $nw=ceil($w*$s);$nh=ceil($h*$s);
    $tmp=imagecreatetruecolor($nw,$nh);
    imagecopyresampled($tmp,$i,0,0,0,0,$nw,$nh,$w,$h);
    $x=($nw-$tw)/2;$y=($nh-$th)/2;
    $out=imagecreatetruecolor($tw,$th);
    imagecopy($out,$tmp,0,0,$x,$y,$tw,$th);
    imagejpeg($out,$dest,85);
    imagedestroy($i);imagedestroy($tmp);imagedestroy($out);
}

$messages=[];
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['slider_images'])){
    $allowed=['jpg','jpeg','png','webp'];
    foreach($_FILES['slider_images']['name'] as $i=>$n){
        if($_FILES['slider_images']['error'][$i]!==0)continue;
        $ext=strtolower(pathinfo($n,PATHINFO_EXTENSION));
        if(!in_array($ext,$allowed)){
            $messages[]=['danger',"Invalid file: $n"];
            continue;
        }
        $new=time().'_'.$n;
        $path="../uploads/".$new;
        move_uploaded_file($_FILES['slider_images']['tmp_name'][$i],$path);
        resizeAndCrop($path,$path);
        mysqli_query($conn,"INSERT INTO cms_slider(slider_image,created_at)VALUES('$new',NOW())");
        $messages[]=['success',"$n uploaded successfully"];
    }
}

$existing=mysqli_query($conn,"SELECT * FROM cms_slider ORDER BY slider_id DESC");
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
body{font-family:'Outfit',sans-serif;background:#fff;color:#111827}
.main-content{margin-left:230px;padding:28px}
@media(max-width:768px){.main-content{margin-left:0}}

.card-box{
  max-width:1100px;margin:auto;background:#fff;
  border-radius:18px;border:1px solid #fde2e2;
  box-shadow:0 14px 30px rgba(0,0,0,.08);
}

.card-header{
  background:#fdecec;padding:20px 26px;
  border-radius:18px 18px 0 0;
}
.card-header h2{
  margin:0;font-size:1.1rem;font-weight:600;
  color:#7f1d1d;display:flex;gap:10px;align-items:center;
}

.card-body{padding:26px}

/* DROPZONE */
.dropzone{
  border:2px dashed #fde2e2;border-radius:14px;
  padding:38px;text-align:center;
  background:#fff7f7;cursor:pointer;
}
.dropzone.dragover{background:#fdecec}

/* 🔥 PREVIEW FIX (MOST IMPORTANT PART) */
.preview-wrapper{
  margin-top:16px;
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  max-height:160px;        /* LIMIT HEIGHT */
  overflow-y:auto;         /* SCROLL INSIDE */
  padding:4px;
}

.preview-wrapper img{
  width:150px;
  height:90px;
  object-fit:cover;
  border-radius:10px;
  border:1px solid #fde2e2;
}

/* BUTTON */
.btn-upload{
  background:#9f1239;color:#fff;border:none;
  padding:10px;font-size:.85rem;font-weight:600;
  border-radius:999px;
}
.btn-upload:hover{background:#7f1d1d}

/* THUMB */
.thumb-card{position:relative;display:inline-block;margin:8px}
.thumb-card img{
  width:160px;height:90px;border-radius:10px;
  border:1px solid #fde2e2;object-fit:cover;
}
.delete-btn{
  position:absolute;top:6px;right:6px;
  background:#fee2e2;color:#991b1b;
  border-radius:8px;padding:6px 8px;
  font-size:12px;text-decoration:none;
}

.alert{border-radius:12px;font-size:.85rem;border:none}
</style>
</head>

<body>
<section class="main-content">
<div class="card-box">

<div class="card-header">
  <h2><i class="fa-solid fa-images"></i> Manage Slider Images</h2>
</div>

<div class="card-body">

<?php foreach($messages as $m): ?>
<div class="alert alert-<?= $m[0]; ?> auto-hide"><?= $m[1]; ?></div>
<?php endforeach; ?>

<?php if(isset($_GET['deleted'])): ?>
<div class="alert alert-success auto-hide">Image deleted successfully</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
<div id="dropzone" class="dropzone">
  <i class="fa-solid fa-cloud-arrow-up fs-2"></i>
  <p class="mt-2"><strong>Drag & Drop Images</strong> or click to browse</p>
  <input type="file" id="fileInput" name="slider_images[]" multiple accept="image/*" hidden>
</div>

<!-- 🔥 FIXED PREVIEW CONTAINER -->
<div id="previews" class="preview-wrapper"></div>

<button class="btn-upload w-100 mt-3">
  <i class="fa-solid fa-upload me-1"></i> Upload Images
</button>
</form>

<hr class="my-4">

<h6 class="fw-semibold mb-3">Existing Images</h6>

<div>
<?php while($r=mysqli_fetch_assoc($existing)): ?>
<div class="thumb-card">
  <img src="../uploads/<?= $r['slider_image']; ?>">
  <a href="?delete=<?= $r['slider_id']; ?>" class="delete-btn"
     onclick="return confirm('Delete image?')">
     <i class="fa-solid fa-trash"></i>
  </a>
</div>
<?php endwhile; ?>
</div>

</div>
</div>
</section>

<script>
const dz=document.getElementById('dropzone'),
fi=document.getElementById('fileInput'),
pv=document.getElementById('previews');

dz.onclick=()=>fi.click();
dz.ondragover=e=>{e.preventDefault();dz.classList.add('dragover')}
dz.ondragleave=()=>dz.classList.remove('dragover')
dz.ondrop=e=>{
 e.preventDefault();dz.classList.remove('dragover');
 fi.files=e.dataTransfer.files;show(fi.files)
}
fi.onchange=()=>show(fi.files)

function show(files){
 pv.innerHTML='';
 [...files].forEach(f=>{
  let r=new FileReader();
  r.onload=e=>{
   let i=document.createElement('img');
   i.src=e.target.result;
   pv.appendChild(i);
  }
  r.readAsDataURL(f);
 })
}

setTimeout(()=>document.querySelectorAll('.auto-hide').forEach(e=>e.remove()),1500);
</script>
</body>
</html>
