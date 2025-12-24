<?php
session_start();
require_once __DIR__ . '/includes/db_connect.php';

$appurl = "http://localhost/CMS-NEW/";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    $phone = mysqli_real_escape_string($conn, $phone);
    $password = mysqli_real_escape_string($conn, $password);

    $query = mysqli_query($conn,
        "SELECT * FROM cms_patients 
         WHERE phone='$phone' AND password='$password'
         LIMIT 1"
    );

    if (mysqli_num_rows($query) > 0) {

        $p = mysqli_fetch_assoc($query);

        if ($p['is_verify'] !== "verified") {
            $error = "Please verify your account before logging in.";
        } else {
            $_SESSION['patient_id'] = $p['patient_id'];
            $_SESSION['loginstatus_patient'] = true;
            header("Location: " . $appurl . "includes/patient/index.php");
            exit;
        }

    } else {
        $error = "Invalid phone or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Patient Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #fff1f1, #fdecec);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
}

/* Card — same style as Doctor Login */
.login-card {
    background: #fde6e6;
    border-radius: 22px;
    padding: 38px 34px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    text-align: center;
}

/* Title */
.login-title {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.18em;
    color: #333;
    margin-bottom: 26px;
}

/* Inputs */
.form-control {
    border-radius: 30px;
    padding: 14px 18px;
    font-size: 14px;
    background: #fff5f5;
    border: 1px solid #f2dcdc;
    margin-bottom: 18px;
}

.form-control:focus {
    box-shadow: none;
    border-color: #000;
}

/* Button — black like Doctor Login */
.btn-login {
    width: 100%;
    border-radius: 30px;
    background: #2c1f1fff;
    color: #fff;
    padding: 13px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.08em;
    border: none;
    transition: all 0.25s ease;
}

.btn-login:hover {
    background: #111;
    transform: translateY(-1px);
}

/* Footer text */
.login-footer {
    font-size: 11px;
    color: #777;
    margin-top: 18px;
}

/* Alerts */
.alert-container {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 380px;
    z-index: 1050;
}

.alert {
    border-radius: 14px;
    font-size: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    transition: opacity 0.3s ease, transform 0.3s ease;
}
</style>
</head>

<body>

<div class="alert-container">
    <?php if (!empty($_GET['verified'])): ?>
        <div id="verifiedAlert" class="alert alert-success text-center">
            Account verified successfully
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div id="errorAlert" class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</div>

<div class="login-card">

    <div class="login-title">PATIENT LOGIN</div>

    <form method="POST" autocomplete="off">
        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>

        <button type="submit" class="btn btn-login">LOGIN</button>
    </form>

    <div class="login-footer">
        Secure Patient Access Portal
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('#verifiedAlert, #errorAlert');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 300);
        }, 2000);
    });
});
</script>

</body>
</html>
