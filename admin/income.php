<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['admin'][$tab_id])) {
    header("Location: ../admin-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$admin_id = $_SESSION['admin'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Income</title>
</head>
<body>
    <?php include("../include/header.php");
    include("../include/connection.php"); ?>
    
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../admin/sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Total Income</h5>
                    <?php
                        $query = "SELECT * FROM income";

                        $res = mysqli_query($connect, $query);

                        $output ="";

                        $output .="<div class='table-responsive'>
                                    <table class='table table-bordered'>
                                        <thead class='thead-dark'>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient Hospital Number</th>
                                                <th>Patient Name</th>
                                                <th>Doctor Name</th>
                                                <th>Date Discharged</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                        if (mysqli_num_rows($res) < 1) {
                            $output .= "
                                <tr>
                                    <td colspan='6' class='text-center'>No Patient Discharge Yet....</td>
                                </tr>
                            ";
                        } else {
                            $counter = 1;
                            while ($row = mysqli_fetch_array($res)) {
                                $output .= "
                                    <tr>
                                        <td>{$counter}</td>
                                        <td>{$row['patient_id']}</td>
                                        <td>{$row['patient_name']}</td>
                                        <td>{$row['doctor_name']}</td>
                                        <td>{$row['date_discharge']}</td>
                                        <td>{$row['amount_paid']}</td>
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
                    
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>