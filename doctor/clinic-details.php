<?php
include('../includes/db_connect.php');
include('includes/header.php');
include('includes/sidebar.php');

/* ================= FETCH DETAILS (UNCHANGED) ================= */
$sql = "SELECT * FROM cms_clinic_details WHERE clinic_id = 1 LIMIT 1";
$result = mysqli_query($conn, $sql);
$clinic = mysqli_fetch_assoc($result);

if (!$clinic) {
    mysqli_query($conn, "INSERT INTO cms_clinic_details 
        (clinic_logo, clinic_name, doctor_name, phone, email, address, about_image, about_title, description, created_at)
        VALUES ('', '', '', '', '', '', '', '', '', NOW())");

    $result = mysqli_query($conn, $sql);
    $clinic = mysqli_fetch_assoc($result);
}

$successMsg = "";

/* ================= UPDATE LOGIC (UNCHANGED) ================= */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $clinic_name = $_POST['clinic_name'];
    $doctor_name = $_POST['doctor_name'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $address     = $_POST['address'];
    $about_title = $_POST['about_title'];
    $description = $_POST['description'];

    $clinic_logo = $clinic['clinic_logo'];
    $about_image = $clinic['about_image'];

    if (!empty($_FILES['logo']['name'])) {
        $newLogo = time() . "_" . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "../uploads/" . $newLogo);
        $clinic_logo = $newLogo;
    }

    if (!empty($_FILES['about_image']['name'])) {
        $newAbout = time() . "_" . $_FILES['about_image']['name'];
        move_uploaded_file($_FILES['about_image']['tmp_name'], "../uploads/" . $newAbout);
        $about_image = $newAbout;
    }

    $update = "UPDATE cms_clinic_details SET
        clinic_logo='$clinic_logo',
        clinic_name='$clinic_name',
        doctor_name='$doctor_name',
        phone='$phone',
        email='$email',
        address='$address',
        about_image='$about_image',
        about_title='$about_title',
        description='$description'
        WHERE clinic_id = 1";

    if (mysqli_query($conn, $update)) {
        $successMsg = "Clinic details updated successfully!";
        $result = mysqli_query($conn, $sql);
        $clinic = mysqli_fetch_assoc($result);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clinic Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ================= BASE ================= */
body{
  background:#fff7f7;
  font-family:'Poppins',sans-serif;
}

/* ================= MAIN CONTENT ================= */
.main-content{
  margin-left:260px;
  padding:40px 24px;
  transition:.3s;
}

/* ================= CARD (MATCH ADD SERVICE) ================= */
.card-wrapper{
  max-width:900px;
  margin:auto;
  background:#fff;
  border-radius:22px;
  overflow:hidden;
  box-shadow:0 20px 40px rgba(0,0,0,0.08);
}

/* Header */
.card-header{
  background:#fdecec;
  padding:18px 24px;
  font-weight:700;
  font-size:20px;
  color:#7a2e2e;
}

/* Body */
.card-body{
  padding:30px;
}

/* Inputs */
.form-control{
  border-radius:14px;
  border:1px solid #f3dcdc;
}
.form-control:focus{
  border-color:#c24141;
  box-shadow:0 0 0 3px rgba(194,65,65,.15);
}

/* Button */
.btn-submit{
  background:#c24141;
  color:#fff;
  border:none;
  padding:12px 26px;
  border-radius:999px;
  font-weight:600;
  float:right;
}
.btn-submit:hover{background:#9f1239}

/* Success */
.success-msg{
  background:#fdecec;
  color:#7a2e2e;
  padding:12px;
  border-radius:12px;
  text-align:center;
  margin-bottom:16px;
  font-weight:600;
}

/* ================= RESPONSIVE ================= */
@media(max-width:992px){
  .main-content{margin-left:0;padding:20px;}
}
</style>
</head>

<body>

<section class="main-content">

<div class="card-wrapper">

<div class="card-header">
  <i class="fa-solid fa-house-chimney-medical me-2"></i>
  Clinic Details
</div>

<div class="card-body">

<?php if($successMsg): ?>
<div class="success-msg" id="alertBox">
  <i class="fa fa-check-circle me-2"></i><?= $successMsg ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="row g-4">

  <div class="col-md-6">
    <label class="form-label">Clinic Logo</label>
    <input type="file" name="logo" class="form-control">
  </div>

  <div class="col-md-6"></div>

  <div class="col-md-6">
    <label class="form-label">Clinic Name</label>
    <input type="text" name="clinic_name" class="form-control"
           value="<?= $clinic['clinic_name'] ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Doctor Name</label>
    <input type="text" name="doctor_name" class="form-control"
           value="<?= $clinic['doctor_name'] ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
           value="<?= $clinic['phone'] ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="<?= $clinic['email'] ?>">
  </div>

  <div class="col-12">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control"><?= $clinic['address'] ?></textarea>
  </div>

  <div class="col-md-6">
    <label class="form-label">About Image</label>
    <input type="file" name="about_image" class="form-control">
  </div>

  <div class="col-md-6">
    <label class="form-label">About Title</label>
    <input type="text" name="about_title" class="form-control"
           value="<?= $clinic['about_title'] ?>">
  </div>

  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control"><?= $clinic['description'] ?></textarea>
  </div>

</div>

<button class="btn-submit mt-4">
  <i class="fa-solid fa-floppy-disk me-2"></i> Update Clinic Details
</button>

</form>

</div>
</div>
</section>

<script>
setTimeout(()=>{
  let box=document.getElementById('alertBox');
  if(box){box.style.opacity='0';setTimeout(()=>box.remove(),600);}
},3000);
</script>

</body>
</html>
