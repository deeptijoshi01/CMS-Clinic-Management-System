<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../send_mail.php';

/* admin login (unchanged) */
if (!function_exists('check_login')) {
    function check_login($conn, $data) {
        $res = array();
        $username = mysqli_real_escape_string($conn, $data['username']);
        $password = mysqli_real_escape_string($conn, $data['password']);
        $query = "SELECT * FROM admin_login WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $res['bool'] = true;
            $_SESSION['loginstatus_doctor'] = true;
        } else {
            $res['bool'] = false;
        }
        return $res;
    }
}

/* fetch single patient */
if (!function_exists('fetch_single_patient')) {
    function fetch_single_patient($conn, $patient_id) {
        $stmt = $conn->prepare("SELECT * FROM cms_patients WHERE patient_id = ?");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

/* add appointment (new or existing). For NEW patient: generate code+password and send email */
if (!function_exists('add_appointment')) {
    function add_appointment($conn, $data) {
        $full_name        = mysqli_real_escape_string($conn, $data['full_name']);
        $age              = mysqli_real_escape_string($conn, $data['age']);
        $phone            = mysqli_real_escape_string($conn, $data['phone']);
        $email            = mysqli_real_escape_string($conn, $data['email']);
        $gender           = mysqli_real_escape_string($conn, $data['gender']);
        $appointment_date = mysqli_real_escape_string($conn, $data['appointment_date']);
        $description      = mysqli_real_escape_string($conn, $data['description']);

        $patient_id = isset($data['patient_id']) ? intval($data['patient_id']) : 0;

        if ($patient_id > 0) {
            $query2 = "INSERT INTO cms_appointments (patient_id, appointment_date, description, status, created_by)
                       VALUES ('$patient_id', '$appointment_date', '$description', 'pending', 'doctor')";
            if (mysqli_query($conn, $query2)) {
                return "APPOINTMENT BOOKED SUCCESSFULLY";
            } else {
                return "ERROR: Failed to add appointment.";
            }
        }

        $verification_code = rand(100000, 999999);
        $password = rand(10000, 99999);

        $query = "INSERT INTO cms_patients (full_name, age, phone, email, gender, verification_code, password, is_verify, created_at)
                  VALUES ('$full_name', '$age', '$phone', '$email', '$gender', '$verification_code', '$password', 'pending', NOW())";

        $result = mysqli_query($conn, $query);
        if ($result) {
            $last_id = mysqli_insert_id($conn);
            mysqli_query($conn, "INSERT INTO cms_appointments (patient_id, appointment_date, description, status, created_by)
                                 VALUES ('$last_id', '$appointment_date', '$description', 'pending', 'doctor')");
            $verify_link = "http://localhost/CMS-NEW/verify-message.php?id=" . $last_id;
            if (!empty($email)) {
                send_verification_email($email, $full_name, $verification_code, $password, $verify_link);
            }
            return "APPOINTMENT BOOKED + EMAIL SENT";
        }
        return "ERROR: Failed to create patient record.";
    }
}


/* fetch all patients */
if (!function_exists('fetch_all_patients')) {
    function fetch_all_patients($conn) {
        $res = array();
        $query = "SELECT p.*, (SELECT appointment_date FROM cms_appointments WHERE cms_appointments.patient_id = p.patient_id ORDER BY appointment_id DESC LIMIT 1) AS latest_appointment_date FROM cms_patients p ORDER BY p.patient_id DESC";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $res['bool'] = true;
            $res['alldata'] = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $res['alldata'][] = $row;
            }
        } else {
            $res['bool'] = false;
            $res['alldata'] = array();
        }
        return $res;
    }
}

/* get total appointments */
if (!function_exists('get_total_appointments')) {
    function get_total_appointments($conn) {
        $query = "SELECT COUNT(*) AS total FROM cms_appointments";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
        return 0;
    }
}

/* fetch appointments by patient */
if (!function_exists('fetch_appointments_by_patient')) {
    function fetch_appointments_by_patient($conn, $patient_id) {
        $stmt = $conn->prepare("SELECT a.*, p.full_name, p.age, p.phone FROM cms_appointments a INNER JOIN cms_patients p ON a.patient_id = p.patient_id WHERE a.patient_id = ? ORDER BY a.appointment_id DESC");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}

/* verify patient by code + password (used on verify page) */
if (!function_exists('verify_patient')) {
    function verify_patient($conn, $data) {
        $patient_id = intval($data['patient_id']);
        $code       = mysqli_real_escape_string($conn, $data['verification_code']);
        $password   = mysqli_real_escape_string($conn, $data['password']);

        $query = "SELECT * FROM cms_patients WHERE patient_id='$patient_id' AND verification_code='$code' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            mysqli_query($conn, "UPDATE cms_patients SET is_verify='verified' WHERE patient_id='$patient_id'");
            return "You are verified";
        }
        return "Invalid code or password";
    }
}

/* patient login (redirect to verify if not yet verified) */
if (!function_exists('patient_login')) {
    function patient_login($conn, $data) {
        $res = array();
        $phone = mysqli_real_escape_string($conn, $data['phone']);
        $password = mysqli_real_escape_string($conn, $data['password']);

        $query = "SELECT * FROM cms_patients WHERE phone='$phone' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['patient_id'] = $row['patient_id'];
            if ($row['is_verify'] !== "verified") {
                $res['bool'] = false;
                $res['redirect'] = "verify-message.php?id=" . $row['patient_id'];
                return $res;
            }
            $_SESSION['loginstatus_patient'] = true;
            $res['bool'] = true;
            return $res;
        }
        $res['bool'] = false;
        return $res;
    }
}
?>
