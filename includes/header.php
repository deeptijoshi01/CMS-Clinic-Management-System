<?php 
$appurl = "http://localhost/CMS-NEW/";
$patienturl = "http://localhost/CMS-NEW/includes/patient/";

// DB
include(__DIR__ . '/../includes/db_connect.php');

// FETCH CLINIC DETAILS
$clinic = mysqli_query($conn, "SELECT * FROM cms_clinic_details LIMIT 1");
$cd = mysqli_fetch_assoc($clinic);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $cd['clinic_name']; ?> - Healthcare System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

  <link rel="stylesheet" href="<?php echo $appurl; ?>includes/patient/assets/css/style.css">
  
 <style>
  /* ================= HEADER THEME (LIGHT) ================= */

  .theme-header {
    background: #2a1b1bff !important;   /* subtle soft pink */
    backdrop-filter: none;
    border-bottom: 1px solid #fde2e2;
    box-shadow: 0 6px 20px rgba(159, 18, 57, 0.08);
  }

  /* Brand */
  .theme-header .navbar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111827 !important;
  }

  .theme-header .brand-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    color: #111827;
  }

  .theme-header .brand-sub {
    font-size: 0.65rem;
    color: #6b7280;
  }

  /* Logo */
  .brand-icon img {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    object-fit: cover;
  }

  /* Nav links */
  .theme-header .nav-link {
    color: #374151 !important;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
  }

  .theme-header .nav-link:hover {
    color: #9f1239 !important;
  }

  .theme-header .nav-link.active {
    color: #9f1239 !important;
    font-weight: 600;
    border-bottom: 2px solid #9f1239;
  }

  /* Doctor Login Button */
  .login-btn {
    background: #111827;
    color: #ffffff !important;
    border-radius: 999px;
    padding: 8px 18px;
    font-weight: 600;
    border: none;
  }

  .login-btn:hover {
    background: #000000;
  }
</style>

</head>

<body>
<nav class="navbar navbar-expand-lg theme-header">
  <div class="container">

    <a class="navbar-brand" href="<?php echo $appurl; ?>">

      <div class="brand-icon">
        <?php if (!empty($cd['clinic_logo'])) { ?>
            <img src="<?php echo $appurl . 'uploads/' . $cd['clinic_logo']; ?>" alt="Clinic Logo">
        <?php } else { ?>
            <i class="fa-solid fa-hospital"></i>
        <?php } ?>
      </div>

      <div>
        <h3 class="brand-title"><?php echo $cd['clinic_name']; ?></h3>
        <div class="brand-sub">Healthcare System</div>
      </div>

    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link active" href="#home">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">ABOUT</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">SERVICES</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">CONTACT</a></li>
      </ul>

    <!-- Doctor Login (Always Visible) -->
<div class="ms-auto">
  <a class="btn btn-warning login-btn"
     href="<?php echo $appurl; ?>doctor/doctor-login.php">
    <i class="fa-solid fa-user-doctor me-1"></i> Doctor Login
  </a>
</div>

    </div>

  </div>
</nav>
