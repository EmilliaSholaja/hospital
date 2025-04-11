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
    <title>Total Reports</title>
</head>
<body>
    <?php include("../include/header.php"); ?>
    
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../doctor/doctor-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Total Reports</h5>
                <?php
                    $doctor_name = '';

                    if ($doctor_id) {
                        $doctor_result = mysqli_query($connect, "SELECT fullName FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
                        if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
                            $row = mysqli_fetch_assoc($doctor_result);
                            $doctor_name = $row['fullName'];
                        }
                    }

                    if (!empty($doctor_name)) {
                        $report_query = mysqli_query($connect, "SELECT * FROM report WHERE doctor_name = '$doctor_name'");
                        $output = "";

                        $output .= "<div class='table-responsive'>
                                    <table class='table table-bordered'>
                                        <thead class='thead-dark'>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient Hospital Number</th>
                                                <th>Title</th>
                                                <th>Message</th>
                                                <th>Date Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                        if (mysqli_num_rows($report_query) < 1) {
                            $output .= "
                                <tr>
                                    <td colspan='5' class='text-center'>No Reports Yet....</td>
                                </tr>
                            ";
                        } else {
                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($report_query)) {
                                $output .= "
                                    <tr>
                                        <td>{$counter}</td>
                                        <td>{$row['PatientNo']}</td>
                                        <td>{$row['title']}</td>
                                        <td>{$row['message']}</td>
                                        <td>{$row['date_sent']}</td>
                                    </tr>
                                ";
                                $counter++;
                            }
                        }

                        $output .= "
                                </tbody>
                            </table>
                        </div>";

                        echo $output;
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>