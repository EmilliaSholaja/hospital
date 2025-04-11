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
    <title>View Patient Details</title>
</head>
<body>
    <?php
      include("../include/header.php");
      include("../include/connection.php");
    ?>

    <div class="main1 container-fluid">
    <div class="col-md-12">
            <div class="row">
        
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../admin/sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-3">View Patient Details</h5>
                    <?php
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                           $id = $_GET['id'];

                           $query = "SELECT * FROM patient WHERE PatientID = '$id'";
                           $res = mysqli_query($connect, $query);

                           if ($res && mysqli_num_rows($res) > 0) {
                               $row = mysqli_fetch_array($res);
                           } else {
                               echo "Patient not found.";
                               exit(); // Exit script if no data found
                           }
                        } else {
                            echo "No patient ID provided.";
                            exit(); // Exit script if no ID parameter in the URL
                        }
                    ?>
                    <div class="col-md-12">
                        <div class="row">
                          
                            <div class="col-md-6">
                                <?php
                                $profile = !empty($row['profile']) ? $row['profile'] : 'patient_default.jpg';
                                   
                                    echo "
                            <img src='../patient/img/$profile' class='col-md-12' style='height: 200px; border: 2px solid #4e34b6; border-radius: 10px; width: 500px;'>
                            ";
                            ?>
                            <br><br>

                                <table class="table table-responsive table-bordered">
                                            <thead>
                                                <th colspan="2" class="text-center">Details</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Patient Hospital Number</td>
                                                    <td><?php echo $row['Patient_No']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Full Name</td>
                                                    <td><?php echo $row['fullName']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><?php echo $row['email']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td><?php echo $row['gender']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number</td>
                                                    <td><?php echo $row['phone_number']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Date Of Birth</td>
                                                    <td><?php echo $row['DOB']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                    <td><?php echo $row['country']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td><?php echo $row['address']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Insurance Provider</td>
                                                    <td><?php echo $row['Insurance_Provider']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Medical History</td>
                                                    <td><?php echo $row['Medical_History']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Current Medications</td>
                                                    <td><?php echo $row['Current_Medications']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Allergies</td>
                                                    <td><?php echo $row['Allergies']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Contact Name</td>
                                                    <td><?php echo $row['E_Contact_Name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Contact Relationship</td>
                                                    <td><?php echo $row['E_Contact_relationship']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Contact Phone</td>
                                                    <td><?php echo $row['E_Contact_phone']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Date Registered</td>
                                                    <td><?php echo $row['data_reg']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        
                            </div>
                            <div class="col-md-6">
                            <?php
                                
                                 if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
         
                                    $query = "SELECT * FROM patient WHERE PatientID = '$id'";
                                    $res = mysqli_query($connect, $query);
         
                                    $row = mysqli_fetch_array($res);
         
                                 }
                                    $patient_no = $row['Patient_No'];

                              // Medical Records
                                $record_query = mysqli_query($connect, "SELECT * FROM medical_records WHERE patient_id = '$patient_no' ORDER BY date DESC");
                                $record = mysqli_fetch_assoc($record_query);

                                // Prescriptions
                                $prescriptions_query = mysqli_query($connect, "SELECT * FROM prescriptions WHERE patient_id = '$patient_no' ORDER BY date DESC");
                                $prescriptions = mysqli_fetch_all($prescriptions_query, MYSQLI_ASSOC);

                                // Lab Results
                                $lab_results_query = mysqli_query($connect, "SELECT * FROM lab_results WHERE patient_id = '$patient_no' ORDER BY date DESC");
                                $lab_results = mysqli_fetch_all($lab_results_query, MYSQLI_ASSOC);
                                  
                                ?>

                                <h5 class="text-center my-2">Patient Medical Records</h5>

                                <?php if ($record) { ?>
                                    <p><strong>Record Type:</strong> <?= htmlspecialchars($record['record_type']) ?></p>
                                    <p><strong>Doctor Name:</strong> <?= htmlspecialchars($record['doctor_name']) ?></p>
                                    <p><strong>Description:</strong> <?= htmlspecialchars($record['description']) ?></p>
                                    <p><strong>Doctor Notes:</strong> <?= htmlspecialchars($record['doctors_notes']) ?></p>
                                    <p><strong>Treatment Plan:</strong> <?= htmlspecialchars($record['treatment_plan']) ?></p>
                                    <p><strong>Height:</strong> <?= htmlspecialchars($record['height']) ?> cm</p>
                                    <p><strong>Weight:</strong> <?= htmlspecialchars($record['weight']) ?> kg</p>
                                    <br>
                                <?php } else { ?>
                                    <p>No medical records found for this patient.</p>
                                <?php } ?>

                                <br>

                                <h5 class="text-center my-2">Prescriptions</h5>
                                <?php if (count($prescriptions) > 0) { ?>
                                    <?php foreach ($prescriptions as $prescription) { ?>
                                        <p><strong>Doctor Name:</strong> <?= htmlspecialchars($prescription['doctor_name']) ?>
                                        <p><strong>Medication:</strong> <?= htmlspecialchars($prescription['medication']) ?> | <strong>Dosage:</strong> <?= htmlspecialchars($prescription['dosage']) ?></p>
                                        <p><strong>Instructions:</strong> <?= htmlspecialchars($prescription['instructions']) ?></p>
                                        <br>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p>No prescriptions found for this patient.</p>
                                <?php } ?>

                                <br>

                                <h5 class="text-center my-2">Lab Results</h5>
                                <?php if (count($lab_results) > 0) { ?>
                                    <?php foreach ($lab_results as $result) { ?>
                                        <p><strong>Doctor Name:</strong> <?= htmlspecialchars($result['doctor_name']) ?>
                                        <p><strong>Test:</strong> <?= htmlspecialchars($result['test_name']) ?> | <strong>Result:</strong> <?= htmlspecialchars($result['result']) ?></p>
                                        <p><strong>Comments:</strong> <?= htmlspecialchars($result['doctors_comments']) ?></p>
                                        <br>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p>No lab results found for this patient.</p>
                                <?php } ?>
<br>
                            </div>
                            <br><br>
                                        <a href="patient.php?tab_id=<?php echo $tab_id; ?>" class="d-grid gap-2 d-md-flex justify-content-center">
                                            <button class="btn btn-info me-md-2">Back</button>
                                        </a>
                                        <br><br>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>

</body>
</html>