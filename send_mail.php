<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ============================
   ADD ONLY THIS (TOP OF FILE)
   ============================ */
define("SMTP_EMAIL", "clinicsender@gmail.com");
define("SMTP_PASS", "mjcjodgtwdnvckhc"); // app password, NO spaces

// Load PHPMailer classes
require __DIR__ . "/phpmailer/src/PHPMailer.php";
require __DIR__ . "/phpmailer/src/SMTP.php";
require __DIR__ . "/phpmailer/src/Exception.php";

/*
|--------------------------------------------------------
| send_verification_email()
| Sends OTP + Verify Link to patient email.
|--------------------------------------------------------
*/
function send_verification_email($to_email, $name, $code, $password, $patient_id)
{
    // BASE URL OF YOUR WEBSITE
    $appurl = "http://localhost/CMS-NEW/";

    // FINAL CORRECT VERIFY LINK
    $verify_link = $appurl . "verify-message.php?id=" . $patient_id;

    $mail = new PHPMailer(true);

    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_EMAIL;   // CHANGED (was hardcoded)
        $mail->Password   = SMTP_PASS;    // CHANGED (was hardcoded)
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;

        // Sender
        $mail->setFrom(SMTP_EMAIL, "Clinic Verification");

        // Receiver
        $mail->addAddress($to_email);

        // Email Format
        $mail->isHTML(true);
        $mail->Subject = "Patient Verification Code";

        // Email Body (UNCHANGED)
        $mail->Body = "
            <div style='font-family:Arial,Helvetica,sans-serif;line-height:1.5;color:#222'>
                <h2>Hello " . htmlentities($name) . ",</h2>

                <p>Your verification code is:</p>
                <h1 style='letter-spacing:6px; font-size:32px; margin:10px 0;'>
                    " . htmlentities($code) . "
                </h1>

                <p>Your login password is:
                    <strong>" . htmlentities($password) . "</strong>
                </p>

                <p style='color:#777;font-size:13px;margin-top:25px;'>
                    If you did not request this, just ignore this email.
                </p>
            </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return "Mail Error: " . $mail->ErrorInfo;
    }
}
?>
