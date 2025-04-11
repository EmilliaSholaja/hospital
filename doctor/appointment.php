<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$doctor_id = $_SESSION['doctor'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Appointment</title>
</head>
<body>
    <?php include("../include/header.php"); ?>
    
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../doctor/doctor-sidenav.php");
                    include("../include/connection.php"); ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Total Appointment</h5>
                    <?php
// Fetch doctor's name
$doctor_name = '';

if ($doctor_id) {
    $doctor_result = mysqli_query($connect, "SELECT fullName FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
    if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
        $row = mysqli_fetch_assoc($doctor_result);
        $doctor_name = $row['fullName'];
    }
}

if (!empty($doctor_name)) {
    // Handle confirmation action
    if (isset($_POST['confirm_id'])) {
        $confirm_id = $_POST['confirm_id'];
        $now = date('Y-m-d H:i:s');
         mysqli_query($connect, "UPDATE appointment SET status='CONFIRMED', confirmed_at='$now' WHERE appointment_id='$confirm_id'");
    }

    // PENDING APPOINTMENTS TABLE
    $pending_query = "SELECT * FROM appointment WHERE doctor_name = '$doctor_name' AND status = 'PENDING'";
    $pending_result = mysqli_query($connect, $pending_query);

    echo "<h5 class='text-center mt-3'>Pending Appointments</h5>";
    echo "<div class='table-responsive'>
            <table class='table table-bordered'>
                <thead class='thead-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Patient Hospital Number</th>
                        <th>Patient Name</th>
                        <th>Appointment Type</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Room Number</th>
                        <th>Symptoms</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Booked At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

    if (mysqli_num_rows($pending_result) < 1) {
        echo "<tr><td colspan='12' class='text-center'>No Pending Appointments</td></tr>";
    } else {
        $counter = 1;
        while ($row = mysqli_fetch_assoc($pending_result)) {
            echo "<tr>
                    <td>{$counter}</td>
                    <td>{$row['patient_id']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>{$row['appointment_type']}</td>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>" . (!empty($row['room_number']) ? $row['room_number'] : "<i>Optional</i>") . "</td>
                    <td>{$row['symptoms']}</td>
                    <td>" . (!empty($row['notes']) ? $row['notes'] : "<i>Optional</i>") . "</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <div class=''d-flex align-items-center justify-content-center'>
                            <form method='post' class='me-2'>
                                <input type='hidden' name='confirm_id' value='{$row['appointment_id']}'>
                                <button type='submit' class='btn btn-success btn-sm'>Confirm</button>
                            </form>
                            <a href='discharge.php?id={$row['appointment_id']}&tab_id={$tab_id}' class='btn btn-primary btn-sm mt-1'>View</a>
                        </div>
                        </td>
                </tr>";
            $counter++;
        }
    }

    echo "  </tbody>
          </table>
        </div>";

    // PREVIOUS APPOINTMENTS TABLE
    $previous_query = "SELECT * FROM appointment WHERE doctor_name = '$doctor_name' AND status != 'PENDING'";
    $previous_result = mysqli_query($connect, $previous_query);

    echo "<h5 class='text-center mt-4'>Previous Appointments</h5>";
    echo "<div class='table-responsive'>
            <table class='table table-bordered'>
                <thead class='thead-dark'>
                    <tr>
                        <th>ID</th>
                        <th>Patient Hospital Number</th>
                        <th>Patient Name</th>
                        <th>Appointment Type</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Room Number</th>
                        <th>Symptoms</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Booked At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";

    if (mysqli_num_rows($previous_result) < 1) {
        echo "<tr><td colspan='12' class='text-center'>No Previous Appointments</td></tr>";
    } else {
        $counter = 1;
        while ($row = mysqli_fetch_assoc($previous_result)) {
            echo "<tr>
                    <td>{$counter}</td>
                    <td>{$row['patient_id']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>{$row['appointment_type']}</td>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>" . (!empty($row['room_number']) ? $row['room_number'] : "<i>Optional</i>") . "</td>
                    <td>{$row['symptoms']}</td>
                    <td>" . (!empty($row['notes']) ? $row['notes'] : "<i>Optional</i>") . "</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                    <td>";

            if ($row['status'] === 'CANCELLED') {
                echo "<span class='text-muted'>Cancelled</span>";
            } else {
                echo "<a href='discharge.php?id={$row['appointment_id']}&tab_id={$tab_id}' class='btn btn-primary btn-sm'>View</a>";
            }

            echo "</td></tr>";
            $counter++;
        }
    }

    echo "  </tbody>
          </table>
        </div>";
}
?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>