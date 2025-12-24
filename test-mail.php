<?php
require 'send_mail.php';

send_verification_email(
    "deeptijoshi01@gmail.com",
    "Test User",
    "123456",
    "99999",
    "http://localhost/CMS-NEW/verify-message.php?id=1"
);

echo "Email Sent!";
