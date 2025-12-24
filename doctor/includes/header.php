<?php 
$doctorurl = "http://localhost/CMS-NEW/doctor/";
include('../includes/db_connect.php');
require_once('functions.php');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DOCTOR's DASHBOARD</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">

<style>
/* ===== LAYOUT FIX ===== */
.main-wrapper{
  margin-left:230px;
  padding:20px;
  transition:.3s;
}

/* MOBILE */
@media(max-width:991px){
  .main-wrapper{
    margin-left:0;
    padding:16px;
  }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar bg-body-tertiary border-bottom">
  <div class="container-fluid">

    <!-- Hamburger (mobile only) -->
    <button class="btn d-lg-none" onclick="toggleDoctorSidebar()">
      <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Brand -->
    <a class="navbar-brand ms-2" href="<?= $doctorurl ?>index.php">
      <strong>DOCTOR</strong>
    </a>

  </div>
</nav>
<div class="main-wrapper">
