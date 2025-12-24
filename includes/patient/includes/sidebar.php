<?php
// make sure $patienturl is defined before including this file
// example:
// $patienturl = "http://localhost/CMS-NEW/includes/patient/";
?>

<!-- ================= MOBILE HEADER ================= -->
<div class="patient-mobile-header">
  <button class="hamburger" onclick="togglePatientSidebar()">
    <i class="fa-solid fa-bars"></i>
  </button>
  <span>Patient Dashboard</span>
</div>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar p-3 patient-sidebar" id="patientSidebar"
     style="
        width:245px;
        height:100vh;
        position:fixed;
        background:#fffafa;
        border-right:1px solid #f3dcdc;
        white-space:nowrap;
        top:0;
        left:0;
     ">

  <!-- HEADER -->
  <div class="d-flex align-items-center mb-3">
    <div style="
        width:36px;
        height:36px;
        border-radius:50%;
        background:#fdecec;
        display:flex;
        align-items:center;
        justify-content:center;
    ">
      <i class="fa-solid fa-heart-pulse" style="color:#c24141;"></i>
    </div>

    <div class="ms-2">
      <div style="
          font-size:12px;
          color:#7a2e2e;
          font-weight:600;
          letter-spacing:0.12em;
          text-transform:uppercase;
      ">
        Patient
      </div>
      <div style="font-size:11px;color:#9a6b6b;">
        Dashboard
      </div>
    </div>
  </div>

  <hr style="border-color:#f3dcdc; margin:0 0 14px 0;">

  <!-- MENU -->
  <ul class="nav flex-column" style="font-size:14px;">

    <li class="nav-item mt-2">
      <a class="nav-link sidebar-link active"
         href="<?php echo $patienturl; ?>index.php">
        <i class="fa-solid fa-house me-2"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link"
         href="<?php echo $patienturl; ?>total-appointments.php">
        <i class="fa-solid fa-file-medical me-2"></i> Total Appointments
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link"
         href="<?php echo $patienturl; ?>upcoming-appointments.php">
        <i class="fa-solid fa-calendar-days me-2"></i> Upcoming Appointments
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link sidebar-link"
         href="<?php echo $patienturl; ?>profile-management.php">
        <i class="fa-solid fa-user me-2"></i> Profile Management
      </a>
    </li>

  </ul>

  <!-- GO TO WEBSITE -->
  <div class="mt-4">
    <a href="http://localhost/CMS-NEW/"
       target="_blank"
       class="btn w-100 d-flex align-items-center justify-content-center gap-2 go-website-btn">
      <i class="fa-solid fa-globe"></i>
      Go to Website
    </a>
  </div>

</div>

<!-- ================= OVERLAY ================= -->
<div class="patient-overlay" id="patientOverlay" onclick="togglePatientSidebar()"></div>

<!-- ================= STYLES ================= -->
<style>
/* Sidebar links */
.sidebar-link {
    border-radius: 10px;
    padding: 8px 10px;
    margin-bottom: 4px;
    color: #374151 !important;
    transition: all 0.2s ease;
}

.sidebar-link i {
    width: 18px;
    text-align: center;
    color: #9a6b6b;
}

.sidebar-link:hover {
    background: #fff3f3;
    color: #7a2e2e !important;
    transform: translateX(2px);
}

.sidebar-link:hover i {
    color: #c24141;
}

/* Active link */
.sidebar-link.active {
    background: #fdecec;
    color: #7a2e2e !important;
    font-weight: 600;
}

.sidebar-link.active i {
    color: #c24141;
}

/* Go to Website Button */
.go-website-btn {
    background: #fdecec;
    color: #7a2e2e;
    border-radius: 999px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    border: 1px solid #f3dcdc;
    transition: all 0.25s ease;
}

.go-website-btn:hover {
    background: #c24141;
    color: #ffffff;
    transform: translateY(-1px);
}

.go-website-btn i {
    font-size: 13px;
    transition: transform 0.25s ease;
}

.go-website-btn:hover i {
    transform: rotate(-8deg) scale(1.1);
}

/* ================= MOBILE HEADER ================= */
.patient-mobile-header {
    display: none;
    align-items: center;
    gap: 12px;
    height: 54px;
    padding: 0 14px;
    background: #fffafa;
    border-bottom: 1px solid #f3dcdc;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1100;
}

.patient-mobile-header span {
    font-size: 14px;
    font-weight: 600;
    color: #7a2e2e;
}

.hamburger {
    background: none;
    border: none;
    font-size: 20px;
    color: #c24141;
}

/* ================= RESPONSIVE ================= */
.patient-sidebar {
    transition: transform 0.3s ease;
    z-index: 1200;
}

.patient-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    z-index: 1100;
}

@media (max-width: 768px) {

    .patient-mobile-header {
        display: flex;
    }

    .patient-sidebar {
        transform: translateX(-100%);
    }

    .patient-sidebar.open {
        transform: translateX(0);
    }

    .patient-overlay.show {
        display: block;
    }

    body {
        padding-top: 54px;
    }
}
</style>

<!-- ================= SCRIPT ================= -->
<script>
function togglePatientSidebar() {
    document.getElementById('patientSidebar').classList.toggle('open');
    document.getElementById('patientOverlay').classList.toggle('show');
}
</script>
