<!-- medical-record.php -->
<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';
if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}
$patient_id = $_SESSION['patient'][$tab_id];
include("../include/connection.php");

// Fetch medical records for this patient
 $query = "SELECT * FROM lab_results WHERE patient_id = '$patient_id' ORDER BY date DESC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Include Bootstrap for styling -->
</head>
<body>
    <?php 
        include("../include/header.php");
        include("../include/connection.php");
    ?>
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../patient/patient-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Lab Results</h5>
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Test Name</th>
                                    <th>Result</th>
                                    <th>Doctor's Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['date'] ?></td>
                                        <td><?= $row['test_name'] ?></td>
                                        <td><?= $row['result'] ?></td>
                                        <td><?= $row['doctors_comments'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-2"></div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>


    </div>
</body>
</html>