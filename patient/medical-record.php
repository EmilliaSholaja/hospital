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
$query = "SELECT * FROM medical_records ORDER BY date DESC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
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
                    <h5 class="text-center my-2">Medical Records</h5>
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-2"></div>
                    <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Doctor Name</th>
                                <th>Doctor's Notes</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Treatment Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['date'] ?></td>
                                    <td><?= $row['description'] ?></td>
                                    <td><?= $row['doctor_name'] ?></td>
                                    <td><?= $row['doctors_notes'] ?></td>
                                    <td><?= $row['weight'] ?></td>
                                    <td><?= $row['height'] ?></td>
                                    <td><?= $row['treatment_plan'] ?></td>
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