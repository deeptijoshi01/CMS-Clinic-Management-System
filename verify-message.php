<?php
require_once __DIR__ . '/includes/db_connect.php';

$patient_id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $code = trim($_POST['verification_code']);

    $query = mysqli_query($conn,
        "SELECT * FROM cms_patients 
         WHERE patient_id='$patient_id' 
         AND verification_code='$code'
         LIMIT 1"
    );

    if (mysqli_num_rows($query) > 0) {

        mysqli_query($conn,
            "UPDATE cms_patients 
             SET is_verify='verified'
             WHERE patient_id='$patient_id'"
        );

        header("Location: patient-login.php?verified=1");
        exit;

    } else {
        $error = "Invalid verification code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Verify Account</title>
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

/* Alert outside card */
.alert-container {
    position: fixed;
    top: 22px;
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

/* Card */
.verify-card {
    background: #fde6e6;
    border-radius: 22px;
    padding: 38px 34px;
    width: 100%;
    max-width: 380px;
    box-shadow: 1px 55px 100px rgba(0,0,0,0.25);
    text-align: center;
}

.verify-title {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.18em;
    color: #333;
    margin-bottom: 26px;
}

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

.btn-verify {
    width: 100%;
    border-radius: 30px;
    background: #000;
    color: #fff;
    padding: 13px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.08em;
    border: none;
    transition: all 0.25s ease;
}

.btn-verify:hover {
    background: #111;
    transform: translateY(-1px);
}

.verify-footer {
    font-size: 11px;
    color: #777;
    margin-top: 18px;
}
</style>
</head>

<body>

<!-- 🔔 ALERT OUTSIDE CARD -->
<div class="alert-container">
    <?php if (!empty($error)): ?>
        <div id="errorAlert" class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</div>

<!-- CARD -->
<div class="verify-card">

    <div class="verify-title">VERIFY ACCOUNT</div>

    <form method="POST" autocomplete="off">
        <input
            type="text"
            name="verification_code"
            class="form-control"
            placeholder="Enter Verification Code"
            required
        >

        <button type="submit" class="btn btn-verify">VERIFY</button>
    </form>

    <div class="verify-footer">
        Secure Patient Verification
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.opacity = '0';
            errorAlert.style.transform = 'translateY(-8px)';
            setTimeout(() => errorAlert.remove(), 300);
        }, 2000);
    }
});
</script>

</body>
</html>
