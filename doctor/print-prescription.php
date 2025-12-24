<?php
require_once('../includes/db_connect.php');
require_once('functions.php');

if (!isset($_GET['aid'])) {
    die("Invalid Appointment ID");
}

$aid = intval($_GET['aid']);

$query = "
    SELECT a.*, p.full_name, p.age, p.phone, p.gender, p.email
    FROM cms_appointments a
    INNER JOIN cms_patients p ON a.patient_id = p.patient_id
    WHERE a.appointment_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $aid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No such appointment found.");
}

$data = $result->fetch_assoc();

// Clinic + Doctor Details
$doctor_name = "Dr. Joshi";
$doctor_specialty = "General Physician";
$clinic_name = "Clinic Management System";
$clinic_address = "Badlapur & Nerul, Maharashtra";
$clinic_phone = "+91 9876543210";
$clinic_email = "clinic@example.com";
?>

<!DOCTYPE html>
<html>
<head>
<title>Prescription</title>

<style>

/* GLOBAL */
body {
    font-family: 'Inter', sans-serif;
    background: #f5f0ff;
    margin: 0;
    padding: 20px;
}

/* CONTAINER */
.prescription-container {
    max-width: 850px;
    margin: auto;
    background: white;
    border-radius: 12px;
    padding: 40px 45px;
    border: 1px solid #d4c7f7;
    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.15);
}

/* HEADER */
.header {
    text-align: center;
    border-bottom: 3px solid #7c3aed;
    padding-bottom: 15px;
    margin-bottom: 25px;
}

.header h1 {
    margin: 0;
    font-size: 32px;
    color: #5b21b6;
    font-weight: 800;
}

.header p {
    margin: 4px 0;
    font-size: 14px;
    color: #6b21a8;
}

/* SECTION TITLE */
.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #5b21b6;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 2px solid #e9d5ff;
}

/* INFO GRID */
.info-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
}

.info-grid p {
    margin: 0;
    flex: 1 1 45%;
    font-size: 15px;
}

.label {
    color: #4c1d95;
    font-weight: 600;
}

/* PRESCRIPTION BOX */
.prescription-box {
    background: #faf5ff;
    border: 1px solid #e6d3ff;
    padding: 18px 20px;
    border-radius: 10px;
    margin-top: 10px;
}

/* RX SYMBOL */
.rx-symbol {
    font-size: 52px;
    color: #6d28d9;
    font-family: "Georgia", serif;
    font-weight: bold;
    margin: 15px 0 10px;
}

/* MEDICATION TABLE */
.medication-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.medication-table th {
    background: #6d28d9;
    color: white;
    font-weight: 600;
    padding: 10px;
    border: 1px solid #5430a8;
}

.medication-table td {
    border: 1px solid #d8c7ff;
    padding: 10px;
    font-size: 14px;
}

/* SIGNATURE SECTION */
.signature-section {
    margin-top: 40px;
    text-align: right;
}

.signature-line {
    border-bottom: 1.5px solid #333;
    width: 180px;
    display: inline-block;
    margin-bottom: 5px;
}

/* FOOTER */
.footer {
    text-align: center;
    font-size: 13px;
    margin-top: 30px;
    color: #6b21a8;
    border-top: 1px solid #e2d4ff;
    padding-top: 12px;
}

/* PRINT BUTTON */
.print-btn {
    background: #7c3aed;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 7px;
    margin: 30px auto 0;
    display: block;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}

.print-btn:hover {
    background: #5b21b6;
}

/* HIDE ELEMENTS WHEN PRINTING */
@media print {
    .print-btn { display: none; }
    body { background: white; }
}

</style>
</head>

<body>

<div class="prescription-container">

    <!-- HEADER -->
    <div class="header">
        <h1><?= $clinic_name ?></h1>
        <p><?= $clinic_address ?></p>
        <p>Phone: <?= $clinic_phone ?> | Email: <?= $clinic_email ?></p>
        <p style="margin-top:8px; font-weight:600; color:#4c1d95;">Medical Prescription</p>
    </div>

    <!-- PATIENT INFO -->
    <div class="section-title">Patient Information</div>
    <div class="info-grid">
        <p><span class="label">Name:</span> <?= $data['full_name'] ?></p>
        <p><span class="label">Age:</span> <?= $data['age'] ?> years</p>
        <p><span class="label">Gender:</span> <?= $data['gender'] ?></p>
        <p><span class="label">Phone:</span> <?= $data['phone'] ?></p>
        <p><span class="label">Email:</span> <?= $data['email'] ?></p>
    </div>

    <br>

    <!-- APPOINTMENT INFO -->
    <div class="section-title">Appointment Details</div>
    <div class="info-grid">
        <p><span class="label">Date:</span> <?= date('d M Y', strtotime($data['appointment_date'])) ?></p>
        <p><span class="label">Reason:</span> <?= $data['description'] ?></p>
    </div>

    <!-- RX SYMBOL -->
    <div class="rx-symbol">℞</div>

    <!-- PRESCRIPTION -->
    <div class="section-title">Prescription</div>
    <div class="prescription-box">
        <p><strong>Doctor Notes:</strong> ____________________________________________</p>
        <p>[ Write diagnosis or instructions here ]</p>

        <br>

        <p><strong>Medications:</strong></p>
        <table class="medication-table">
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>Frequency</th>
                    <th>Duration</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>[Medicine 1]</td>
                    <td>[500mg]</td>
                    <td>[2× daily]</td>
                    <td>[7 days]</td>
                    <td>[After meals]</td>
                </tr>
                <tr>
                    <td>[Medicine 2]</td>
                    <td>[10mg]</td>
                    <td>[1× daily]</td>
                    <td>[5 days]</td>
                    <td>[Morning]</td>
                </tr>
            </tbody>
        </table>

        <br>
        <p><strong>Additional Instructions:</strong> [Follow-up after 7 days]</p>
    </div>

    <!-- SIGNATURE SECTION -->
    <div class="signature-section">
        <span class="signature-line"></span><br>
        <?= $doctor_name ?> — <?= $doctor_specialty ?><br>
        Date: <?= date('d M Y') ?>
    </div>

    <div class="footer">
        Confidential medical record. Not valid without doctor signature.
    </div>

</div>

<button class="print-btn" onclick="window.print();">Print Prescription</button>

</body>
</html>
