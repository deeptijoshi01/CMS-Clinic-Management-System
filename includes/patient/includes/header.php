<?php 
// Base URL for all patient pages (folder that contains index.php, total-appointments.php, etc.)
$patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PATIENT DASHBOARD</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Correct CSS Path (from /patient/includes/ to /patient/assets/css/) -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">

    <a class="navbar-brand" href="<?php echo $patienturl; ?>index.php">
      <h1 class="m-0">PATIENT</h1>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarNav" aria-controls="navbarNav" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- LOGOUT BUTTON -->
    <!-- <a href="#" class="btn btn-danger">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a> -->
    <a href="#" class="btn btn-danger" style="
  border-radius: 999px;
  padding: 6px 18px;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  background: linear-gradient(135deg, #ef4444, #b91c1c);
  border: none;
  box-shadow: 0 8px 16px rgba(185, 28, 28, 0.45);
  display: inline-flex;
  align-items: center;
  transition: all 0.25s ease-in-out;
">
  <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
</a>


  </div>
</nav>

<!-- MAIN CONTENT STARTS HERE -->
<div style="margin-left: 210px; padding: 20px;">
