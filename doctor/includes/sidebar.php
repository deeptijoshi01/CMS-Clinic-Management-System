<?php
$doctorurl = "http://localhost/CMS-NEW/doctor/";
?>

<div class="doctor-sidebar p-3">

  <!-- HEADER -->
  <div class="d-flex align-items-center mb-4">
    <div class="icon-circle">
      <i class="fa-solid fa-user-doctor"></i>
    </div>
    <div class="ms-2">
      <div class="title">Doctor</div>
      <div class="subtitle">Dashboard</div>
    </div>
  </div>

  <hr>

  <ul class="nav flex-column">

    <li class="nav-item">
      <a class="nav-link sidebar-link active" href="<?= $doctorurl ?>index.php">
        <i class="fa-solid fa-house"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>total-patients.php">
        <i class="fa-solid fa-users"></i> Patients
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>total-appointments.php">
        <i class="fa-solid fa-calendar-check"></i> Appointments
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>clinic-details.php">
        <i class="fa-solid fa-house-chimney-medical"></i> Clinic Details
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>add-services.php">
        <i class="fa-solid fa-hand-holding-medical"></i> Services
      </a>
    </li>

    <li class="nav-item mt-4">
      <a href="<?= $doctorurl ?>logout.php" class="logout-btn">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </li>

  </ul>
</div>

<div class="sidebar-overlay" onclick="toggleDoctorSidebar()"></div>

<style>
.doctor-sidebar{
  width:230px;
  height:100vh;
  position:fixed;
  left:0;
  top:0;
  background:#fff7f7;
  border-right:1px solid #fde2e2;
  z-index:1050;
  transition:transform .3s ease;
}

.icon-circle{
  width:36px;height:36px;border-radius:50%;
  background:#fdecec;
  display:flex;align-items:center;justify-content:center;
}
.icon-circle i{color:#9f1239;}

.title{font-size:12px;font-weight:600;color:#7f1d1d;}
.subtitle{font-size:11px;color:#6b7280;}

.sidebar-link{
  display:flex;align-items:center;gap:10px;
  padding:9px 12px;border-radius:12px;
  color:#374151!important;
}
.sidebar-link:hover{background:#fdecec;}
.sidebar-link.active{background:#fce7e7;font-weight:600;}

.logout-btn{
  display:block;text-align:center;
  background:#fee2e2;color:#991b1b!important;
  padding:10px;border-radius:14px;font-weight:600;
}

@media(max-width:991px){
  .doctor-sidebar{transform:translateX(-100%);}
  .doctor-sidebar.open{transform:translateX(0);}
  .sidebar-overlay{
    display:none;
    position:fixed;inset:0;
    background:rgba(0,0,0,.35);
    z-index:1040;
  }
  .sidebar-overlay.active{display:block;}
}
</style>

<script>
function toggleDoctorSidebar(){
  document.querySelector('.doctor-sidebar').classList.toggle('open');
  document.querySelector('.sidebar-overlay').classList.toggle('active');
}
</script>
