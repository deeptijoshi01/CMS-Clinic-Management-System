<?php
// make sure $doctorurl is defined before including this file
?>

<!-- ============ MOBILE TOP BAR (ONLY MOBILE) ============ -->
<div class="doctor-mobile-navbar">
  <button class="doctor-hamburger" onclick="toggleDoctorSidebar()">
    <span></span>
    <span></span>
    <span></span>
  </button>
</div>

<!-- ============ SIDEBAR ============ -->
<div class="doctor-sidebar p-3"
     style="
       width:230px;
       height:100vh;
       position:fixed;
       left:0;
       top:0;
       background:#fff7f7;
       border-right:1px solid #fde2e2;
       font-family:'Outfit', system-ui, sans-serif;
       overflow-y:auto;
       overflow-x:hidden;
       z-index:1050;
     ">

  <!-- HEADER -->
  <div class="d-flex align-items-center mb-4">
    <div style="
      width:36px;height:36px;border-radius:50%;
      background:#fdecec;
      display:flex;align-items:center;justify-content:center;
    ">
      <i class="fa-solid fa-user-doctor" style="color:#9f1239;font-size:14px;"></i>
    </div>

    <div class="ms-2">
      <div style="
        font-size:12px;font-weight:600;color:#7f1d1d;
        letter-spacing:0.06em;text-transform:uppercase;
      ">Doctor</div>
      <div style="font-size:11px;color:#6b7280;">Dashboard</div>
    </div>
  </div>

  <hr style="border-color:#fde2e2;margin-bottom:12px;">

  <!-- MENU -->
  <ul class="nav flex-column" style="font-size:14px;font-weight:500;">

    <li class="nav-item mb-1">
      <a class="nav-link sidebar-link active" href="<?= $doctorurl ?>index.php">
        <i class="fa-solid fa-house"></i> Dashboard
      </a>
    </li>

    <li class="nav-item mb-1">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>total-patients.php">
        <i class="fa-solid fa-users"></i> Patients
      </a>
    </li>

    <li class="nav-item mb-1">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>total-appointments.php">
        <i class="fa-solid fa-calendar-check"></i> Appointments
      </a>
    </li>

    <li class="nav-item mb-1">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>clinic-details.php">
        <i class="fa-solid fa-house-chimney-medical"></i> Clinic Details
      </a>
    </li>

    <li class="nav-item mb-1">
      <a class="nav-link sidebar-link" href="<?= $doctorurl ?>add-services.php">
        <i class="fa-solid fa-hand-holding-medical"></i> Services
      </a>
    </li>

    <li class="nav-item mt-4">
      <a href="<?= $doctorurl ?>logout.php" class="logout-btn">
        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
      </a>
    </li>

  </ul>
</div>

<!-- OVERLAY -->
<div class="doctor-overlay" onclick="toggleDoctorSidebar()"></div>

<!-- ============ INLINE STYLES ============ -->
<style>
/* Links */
.sidebar-link{
  display:flex;
  align-items:center;
  gap:10px;
  padding:9px 12px;
  border-radius:12px;
  color:#374151!important;
  transition:.2s;
}
.sidebar-link i{
  width:18px;
  text-align:center;
  color:#9f1239;
}
.sidebar-link:hover{
  background:#fdecec;
}
.sidebar-link.active{
  background:#fce7e7;
  font-weight:600;
}

/* Logout */
.logout-btn{
  display:block;
  text-align:center;
  background:#fee2e2;
  color:#991b1b!important;
  padding:10px;
  border-radius:14px;
  font-weight:600;
}

/* Sidebar base */
.doctor-sidebar{
  transition:transform .3s ease;
}

/* MOBILE NAVBAR */
.doctor-mobile-navbar{
  display:none;
  height:52px;
  background:#fff7f7;
  border-bottom:1px solid #fde2e2;
  padding:0 14px;
  align-items:center;
  position:fixed;
  top:0;left:0;right:0;
  z-index:1100;
}

.doctor-hamburger{
  background:none;
  border:none;
  display:flex;
  flex-direction:column;
  gap:5px;
}

.doctor-hamburger span{
  width:22px;
  height:2px;
  background:#7f1d1d;
}

/* Overlay */
.doctor-overlay{
  display:none;
}

/* MOBILE BEHAVIOR */
@media (max-width: 991px){

  .doctor-mobile-navbar{
    display:flex;
  }

  .doctor-sidebar{
    transform:translateX(-100%);
    top:0;
    left:0;
    height:100vh;
    box-shadow:4px 0 12px rgba(0,0,0,.15);
  }

  .doctor-sidebar.open{
    transform:translateX(0);
  }

  .doctor-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.35);
    z-index:1040;
  }

  .doctor-overlay.active{
    display:block;
  }
}
</style>

<!-- ============ INLINE SCRIPT ============ -->
<script>
function toggleDoctorSidebar(){
  document.querySelector('.doctor-sidebar').classList.toggle('open');
  document.querySelector('.doctor-overlay').classList.toggle('active');
}
</script>
