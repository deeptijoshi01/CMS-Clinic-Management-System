<?php
$doctorurl = "http://localhost/CMS-NEW/doctor/";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Doctor Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
  font-family:'Outfit',system-ui,sans-serif;
  background:#fff;
}

/* Layout */
.main-wrapper{
  margin-left:230px;
  padding:32px;
  transition:.3s;
}

@media(max-width:991px){
  .main-wrapper{
    margin-left:0;
    padding:20px;
  }
}

/* Dashboard cards */
.dash-card{
  background:#fff7f7;
  border:1px solid #fde2e2;
  border-left:4px solid #f4a7a7;
  border-radius:16px;
  padding:22px;
  transition:.25s;
}
.dash-card:hover{
  transform:translateY(-4px);
  box-shadow:0 14px 30px rgba(0,0,0,.08);
}
</style>
</head>

<body>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="main-wrapper">

  <h4>Doctor Overview</h4>
  <p class="text-muted mb-4">
    Summary of your patients and appointment activity
  </p>

  <div class="row g-4">

    <div class="col-md-4">
      <div class="dash-card">
        <strong>Total Patients</strong>
        <p class="text-muted mb-1">All registered patients</p>
        <a href="<?= $doctorurl ?>total-patients.php">View list →</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="dash-card">
        <strong>Today’s Appointments</strong>
        <p class="text-muted mb-1">Scheduled for today</p>
        <a href="<?= $doctorurl ?>todays-appointments.php">View schedule →</a>
      </div>
    </div>

    <div class="col-md-4">
      <div class="dash-card">
        <strong>Upcoming Appointments</strong>
        <p class="text-muted mb-1">Next 30 days</p>
        <a href="<?= $doctorurl ?>upcoming-appointments.php">View schedule →</a>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
