<?php
// OPTIONAL: Add header or redirect protection if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Confirmed</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: #f5f0ff;
    font-family: Poppins, sans-serif;
}

.thank-box {
    max-width: 650px;
    margin: 80px auto;
    padding: 40px;
    text-align: center;
    background: white;
    border-radius: 25px;
    box-shadow: 0 10px 35px rgba(139,92,246,0.25);
    border: 1px solid rgba(139,92,246,0.3);
}

.thank-box i {
    font-size: 70px;
    color: #8b5cf6;
    margin-bottom: 20px;
}

.btn-home {
    background: linear-gradient(135deg, #8b5cf6, #6b46c1);
    color: #fff;
    padding: 12px 28px;
    font-size: 17px;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 8px 18px rgba(139,92,246,0.35);
}
.btn-home:hover {
    transform: translateY(-3px);
    color: white;
}
</style>

</head>
<body>

<div class="thank-box">
    <i class="fa-solid fa-circle-check"></i>
    <h1>Appointment Submitted!</h1>
    <p class="mt-3">
        Thank you for booking your appointment.  
        Our clinic will review it and confirm soon.
    </p>

    <a href="../index.php" class="btn-home mt-4">Go Back to Home</a>
</div>

</body>
</html>
