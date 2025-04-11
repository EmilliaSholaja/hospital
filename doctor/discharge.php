<?php
session_start();
include("../include/connection.php");

$tab_id = $_GET['tab_id'] ?? '';
$id = $_GET['id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'][$tab_id];

// Fetch doctor name from session
$doctor_query = mysqli_query($connect, "SELECT fullName FROM doctor");
$doctor = mysqli_fetch_assoc($doctor_query);
$doctor_name = $doctor['fullName'];

// Fetch appointment data to get patient details
$appt_query = mysqli_query($connect, "SELECT patient_id, patient_name, status FROM appointment WHERE appointment_id = '$id'");
$appt = mysqli_fetch_assoc($appt_query);
$patient_id = $appt['patient_id'];
$patient_name = $appt['patient_name'];

if (isset($_POST['create_invoice'])) {
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    $amount = floatval($_POST['amount']);
    $status = $_POST['status'];

    $query = "INSERT INTO income (patient_id, patient_name, doctor_name, description, amount_paid, date_discharge, status)
              VALUES ('$patient_id', '$patient_name', '$doctor_name', '$description', '$amount', NOW(), '$status')";

    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Invoice created successfully!')</script>";

        // Update the status to DISCHARGED
        mysqli_query($connect, "UPDATE appointment SET status = 'DISCHARGED', discharged_at = NOW() WHERE appointment_id = '$id'");
        echo "<script>window.location.href = 'discharge.php?id=$id&tab_id=$tab_id';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "')</script>";
    }
}

// Handling the Complete Button click
if (isset($_POST['complete_appointment'])) {
    // Update the status to COMPLETED
    mysqli_query($connect, "UPDATE appointment SET status = 'COMPLETED', completed_at = NOW() WHERE appointment_id = '$id'");
    echo "<script>alert('Appointment marked as completed!')</script>";
    echo "<script>window.location.href = 'appointment.php?&tab_id=$tab_id';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Patient Appointment</title>
</head>
<body>
    <?php include("../include/header.php"); ?>
    
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../doctor/doctor-sidenav.php"); ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Check Patient Appointment Details</h5>
                    <?php
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $query = "SELECT * FROM appointment WHERE appointment_id = '$id'";
                            $res = mysqli_query($connect, $query);
                            $row = mysqli_fetch_assoc($res);
                        } else {
                            echo "<script>alert('No appointment found.')</script>";
                            exit();
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="my-3 table-container">
                                    <table class="table table-responsive table-bordered">
                                        <thead><th colspan="2" class="text-center">Appointment Details</th></thead>
                                        <tbody>
                                            <tr><td>Patient Hospital Number</td><td><?php echo $row['patient_id']; ?></td></tr>
                                            <tr><td>Patient Name</td><td><?php echo $row['patient_name']; ?></td></tr>
                                            <tr><td>Appointment Type</td><td><?php echo $row['appointment_type']; ?></td></tr>
                                            <tr><td>Appointment Date</td><td><?php echo $row['appointment_date']; ?></td></tr>
                                            <tr><td>Appointment Time</td><td><?php echo $row['appointment_time']; ?></td></tr>
                                            <tr><td>Room Number</td><td><?php echo !empty($row['room_number']) ? $row['room_number'] : '<i>Optional</i>'; ?></td></tr>
                                            <tr><td>Symptoms</td><td><?php echo $row['symptoms']; ?></td></tr>
                                            <tr><td>Notes</td><td><?php echo !empty($row['notes']) ? $row['notes'] : '<i>Optional</i>'; ?></td></tr>
                                            <tr><td>Status</td><td><?php echo $row['status']; ?></td></tr>
                                            <tr><td>Booked at </td><td><?php echo $row['created_at']; ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center my-1">Invoice</h5>
                                <form action="" method="POST">
                                    <label>Patient Hospital Number:</label>
                                    <input type="text" readonly name="patient_id" class="form-control" value="<?php echo $patient_id; ?>"><br>
                                    <label for="">Patient Name:</label>
                                    <input type="text" readonly name="patient_name" class="form-control" value="<?php echo $patient_name; ?>"><br>

                                    <label>Doctor Name:</label>
                                    <input type="text" readonly name="doctor_name" class="form-control" value="<?php echo $doctor_name; ?>"><br>

                                    <label>Amount (₦):</label>
                                    <input type="number" name="amount" step="0.01" class="form-control" required><br>

                                    <label>Description:</label>
                                    <textarea name="description" class="form-control" required></textarea><br>

                                    <label>Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Paid">Paid</option>
                                    </select><br>
                                    <?php if ($row['status'] !== 'COMPLETED') { ?>
                                    <button type="submit" class="btn btn-dark" name="create_invoice">Create Invoice</button>
                                    <br><br>

                                    <!-- Complete Button -->
                                   
                                </form>
                                
                                  <!-- Correct the form for the Complete button -->
                                <form method='post'>
                                    <input type='hidden' name='complete_id' value='<?php echo $row['appointment_id']; ?>'>
                                    <button type="submit" class="btn btn-success" name="complete_appointment">Complete</button>
                                    <br><br>
                                </form>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</body>
</html>