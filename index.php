<?php 
include('includes/header.php'); 
include('includes/db_connect.php');

/* ================= FETCH DATA ================= */
$clinic = mysqli_query($conn, "SELECT * FROM cms_clinic_details LIMIT 1");
$cd = mysqli_fetch_assoc($clinic);

$sliders = mysqli_query($conn, "SELECT * FROM cms_slider ORDER BY slider_id DESC");
$services = mysqli_query($conn, "SELECT * FROM cms_services ORDER BY service_id DESC");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $cd['clinic_name']; ?> - Healthcare System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
  --accent: #c24141;
  --accent-soft: #fdecec;
  --accent-border: #f3dcdc;
  --text-dark: #1f2937;
  --text-muted: #6b7280;
}

/* ================= BASE ================= */
body {
  background: #ffffff;
  font-family: 'Smooch Sans', system-ui, sans-serif;
  color: var(--text-dark);
  overflow-x: hidden;
}

/* ================= NAVBAR ================= */
.navbar,
.navbar-brand,
.navbar-nav .nav-link {
  color: #ffffff !important;
  font-weight: 500;
  letter-spacing: 0.08em;
}

.navbar-nav .nav-link {
  position: relative;
  transition: all 0.25s ease;
}

.navbar-nav .nav-link::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 0%;
  height: 2px;
  background: #ffffff;
  transition: width 0.3s ease;
}

.navbar-nav .nav-link:hover::after,
.navbar-nav .nav-link.active::after {
  width: 100%;
}

.navbar-toggler {
  border-color: rgba(255,255,255,0.6);
}
.navbar-toggler-icon {
  filter: brightness(0) invert(1);
}

/* ================= LOGIN BUTTON ================= */
.navbar .btn,
.navbar a[href*="doctor"] {
  background: #111 !important;
  color: #fff !important;
  border-radius: 999px;
  padding: 8px 18px;
  font-weight: 600;
  transition: all 0.25s ease;
}

.navbar .btn:hover,
.navbar a[href*="doctor"]:hover {
  background: #000 !important;
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.35);
}

/* ================= HERO ================= */
#home .carousel-item img {
  height: 100vh;
  object-fit: cover;
  filter: brightness(65%);
}

.carousel-caption h1 {
  font-weight: 700;
}

.carousel-caption .btn {
  background: var(--accent);
  color: #fff;
  border-radius: 999px;
  padding: 10px 26px;
  border: none;
}

.carousel-caption .btn:hover {
  background: #9f3030;
}

/* ================= SECTION HEADERS ================= */
.section-header h1 {
  font-size: 2.6rem;
  font-weight: 700;
  color: var(--accent);
}

.section-header p {
  color: var(--text-muted);
}

/* ================= ABOUT ================= */
.about-img {
  border-radius: 22px;
  box-shadow: 0 18px 42px rgba(194,65,65,0.18);
  transition: .35s;
}
.about-img:hover {
  transform: translateY(-10px);
}

/* ================= SERVICES ================= */
.service-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 28px;
  border: 1px solid var(--accent-border);
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  transition: .3s;
  height: 100%;
  text-align: center;
}

.service-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.14);
}

.service-card i {
  color: var(--accent);
}

/* ================= APPOINTMENT ================= */
#appointment .bg-white {
  border-radius: 20px;
  border: 1px solid var(--accent-border);
}

#appointment .btn-primary {
  background: var(--accent);
  border: none;
  border-radius: 999px;
}

#appointment .btn-primary:hover {
  background: #9f3030;
}

/* ================= CONTACT ================= */
#contact .bg-white {
  border-radius: 18px;
  border: 1px solid var(--accent-border);
}

iframe {
  border-radius: 14px;
}
</style>
</head>

<body>

<!-- ================= HERO SLIDER ================= -->
<section id="home">
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<?php
$active = true;
if (mysqli_num_rows($sliders) > 0):
  while ($s = mysqli_fetch_assoc($sliders)): ?>
    <div class="carousel-item <?= $active ? 'active' : '' ?>">
      <img src="<?= $appurl . 'uploads/' . $s['slider_image']; ?>" class="d-block w-100">
      <div class="carousel-caption text-start">
        <h1>Welcome to <?= $cd['clinic_name']; ?></h1>
        <p>Your Trusted Healthcare Partner</p>
        <a href="#appointment" class="btn btn-lg">Book Now</a>
      </div>
    </div>
<?php $active = false; endwhile; endif; ?>
</div>
</div>
</section>

<!-- ================= ABOUT ================= -->
<section id="about" class="py-5 bg-white">
<div class="section-header text-center py-4">
<h1><?= $cd['about_title']; ?></h1>
<p><?= $cd['description']; ?></p>
</div>

<div class="container">
<div class="row align-items-center g-5">
<div class="col-lg-5">
<img src="<?= $appurl . 'uploads/' . $cd['about_image']; ?>" class="img-fluid about-img">
</div>
<div class="col-lg-7">
<h2><?= $cd['clinic_name']; ?></h2>
<p class="lead">Doctor: <strong><?= $cd['doctor_name']; ?></strong></p>
<p><?= $cd['description']; ?></p>
</div>
</div>
</div>
</section>

<!-- ================= SERVICES ================= -->
<section id="services" class="py-5">
<div class="section-header text-center mb-5">
<h1>OUR SERVICES</h1>
<p>Comprehensive care across multiple specialties</p>
</div>

<div class="container">
<div class="row g-4">
<?php if (mysqli_num_rows($services) > 0):
  while ($srv = mysqli_fetch_assoc($services)): ?>
  <div class="col-md-4 col-lg-3">
    <div class="service-card">
      <i class="<?= $srv['icon']; ?>" style="font-size:42px;"></i>
      <h3 class="mt-3"><?= $srv['title']; ?></h3>
      <p class="text-muted"><?= $srv['description']; ?></p>
    </div>
  </div>
<?php endwhile; else: ?>
<p class="text-center">No services added yet.</p>
<?php endif; ?>
</div>
</div>
</section>

<!-- ================= APPOINTMENT ================= -->
<section id="appointment" class="py-5">
<div class="container">
<div class="row align-items-center g-5">
<div class="col-lg-6 text-center">
<img src="<?= $appurl; ?>includes/assets/images/AP.png" class="img-fluid" style="max-width:85%;">
</div>

<div class="col-lg-6">
<div class="p-5 bg-white shadow-sm">
<h3 class="text-center mb-4">BOOK AN APPOINTMENT</h3>
<form method="POST" action="<?= $appurl; ?>doctor/submit-appointment.php">
<input type="text" name="full_name" class="form-control mb-2" placeholder="Full Name" required>
<input type="tel" name="phone" class="form-control mb-2" placeholder="Phone No." required>
<input type="email" name="email" class="form-control mb-2" placeholder="Email">
<input type="number" name="age" class="form-control mb-2" placeholder="Age" required>
<select name="gender" class="form-select mb-2" required>
<option disabled selected>Select Gender</option>
<option>Male</option><option>Female</option><option>Other</option>
</select>
<input type="date" name="appointment_date" class="form-control mb-2" required>
<textarea name="description" class="form-control mb-3" rows="3" placeholder="Describe your concern"></textarea>
<button
  class="btn w-100"
  style="
    background:#7a2e2e;
    color:#ffffff;
    border-radius:999px;
    padding:11px 28px;
    font-weight:600;
    letter-spacing:0.05em;
    border:none;
    transition:all 0.25s ease;
  "
  onmouseover="this.style.background='#5f1f1f'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 24px rgba(0,0,0,0.35)';"
  onmouseout="this.style.background='#7a2e2e'; this.style.transform='translateY(0)'; this.style.boxShadow='none';"
>
  BOOK APPOINTMENT
</button>

</form>
</div>
</div>
</div>
</div>
</section>

<!-- ================= CONTACT ================= -->
<section id="contact" class="py-5" style="background:#fafafa;">
<div class="container">
<div class="text-center mb-5">
<h2 class="fw-bold">Contact Us</h2>
<p class="text-muted">We’re here to help you.</p>
</div>

<div class="row g-4">
<div class="col-md-6">
<div class="p-4 bg-white shadow-sm">
<h5>Clinic Information</h5>
<p><strong><?= $cd['clinic_name']; ?></strong></p>
<p>📞 +91 98765 43210</p>
<p>✉️ clinic@example.com</p>
<p>📍 Badlapur & Nerul, Maharashtra</p>
</div>
</div>

<div class="col-md-6">
<div class="p-4 bg-white shadow-sm">
<h5>Clinic Location</h5>
<iframe src="https://www.google.com/maps?q=Badlapur%20Maharashtra&output=embed"
width="100%" height="250" style="border:0;"></iframe>
</div>
</div>
</div>
</div>
</section>

<?php include('includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
