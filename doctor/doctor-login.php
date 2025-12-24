<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../includes/db_connect.php');
include('functions.php');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Doctor Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, #ffecec, #fff5f5);
    }

    .login-card {
      width: 100%;
      max-width: 380px;
      background: rgba(255, 227, 227, 0.85);
      backdrop-filter: blur(18px);
      border-radius: 26px;
      padding: 36px 30px;
      box-shadow: 0 25px 100px rgba(0,0,0,0.25);
    }

    .login-title {
      text-align: center;
      font-weight: 600;
      letter-spacing: 0.18em;
      font-size: 14px;
      color: #3a3a3a;
      margin-bottom: 28px;
    }

    .form-control {
      border-radius: 40px;
      padding: 14px 18px;
      border: none;
      background: rgba(255,255,255,0.55);
      box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08);
      font-size: 14px;
    }

    .form-control:focus {
      outline: none;
      box-shadow: inset 0 0 0 1px #000;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #444;
    }

    .btn-login {
      width: 100%;
      border-radius: 40px;
      padding: 13px;
      background: #000;
      color: #fff;
      font-weight: 500;
      letter-spacing: 0.1em;
      border: none;
      margin-top: 18px;
      transition: all 0.25s ease;
    }

    .btn-login:hover {
      background: #222;
      transform: translateY(-1px);
    }

    .footer-text {
      text-align: center;
      font-size: 11px;
      color: #555;
      margin-top: 22px;
      opacity: 0.7;
    }
  </style>
</head>

<body>

<div class="login-wrapper">

  <div class="login-card">

    <div class="login-title">DOCTOR LOGIN</div>

    <!-- LOGIN PROCESS (UNCHANGED) -->
    <?php
      if(isset($_POST['submit'])) {
        $res = check_login($conn, $_POST);
        if ($res['bool'] == true) {
          $_SESSION['loginstatus_doctor'] = true;
          header('Location: index.php');
          exit();
        } else {
          echo "<div class='alert alert-danger text-center py-2'>Invalid Username or Password</div>";
        }
      }
    ?>

    <form method="post">

      <div class="mb-3 input-group">
        <span class="input-group-text">
          <i class="fa-regular fa-user"></i>
        </span>
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>

      <div class="mb-2 input-group">
        <span class="input-group-text">
          <i class="fa-solid fa-lock"></i>
        </span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <button type="submit" name="submit" class="btn-login">
        LOGIN
      </button>

    </form>

    <div class="footer-text">
      Secure Doctor Access Portal
    </div>

  </div>

</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
