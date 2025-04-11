<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

// You can access the logged-in doctor ID using:
$doctor_id = $_SESSION['doctor'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Patients</title>
    <style>
         .table-responsive {
                max-height: 400px; /* Reduce height */
                overflow-y: auto;
            }

            table {
                width: 90%; /* Adjust width */
                margin: auto; /* Center table */
                border-collapse: collapse; /* Remove spacing between cells */
            }

  

            th {
                background-color: #f8f9fa; /* Light gray background */
                font-size: 15px; /* Slightly larger font for headers */
                text-align: center; 
                vertical-align: middle;
                padding: 5px; /* Reduce padding */
                font-size: 14px; /* Reduce font size */
                white-space: nowrap; /* Keep content in one line */
            
            }

            td {
                border: 1px solid #ddd; /* Add thin borders */
                text-align: left; 
                vertical-align: middle;
                padding: 5px; /* Reduce padding */
                font-size: 14px; /* Reduce font size */
                white-space: nowrap; /* Keep content in one line */
            }
            
    </style>
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
                    <?php include("../doctor/doctor-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                            <h5 class="text-center">Total Patient</h5>
                            <?php
                                $query = "SELECT * FROM patient";
                                $res = mysqli_query($connect, $query);

                                $output="";

                                $output .= "
                                <div class='table-responsive'>  <!-- ADD THIS -->
                                    <table class='table table-bordered'>
                                        <thead class='thead-dark'>  <!-- Bootstrap styling for better appearance -->
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient Hospital Number</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Phone Number</th>
                                                <th>Date Of Birth</th>
                                                <th>Country</th>
                                                <th>Address</th>
                                                <th>Insurance Provider</th>
                                                <th>Medical History</th>
                                                <th>Current Medications</th>
                                                <th>Allergies</th>
                                                <th>Emergency Contact Name</th>
                                                <th>Emergency Contact Relationship</th>
                                                <th>Emergency Contact Phone Number</th>
                                                <th>Date Registered</th>
                                                <th class='text-center'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            ";
                    
                    
                        if (mysqli_num_rows($res) < 1) {
                            $output .= "
                                <tr>
                                    <td colspan='18' class='text-center'>No Patients Yet....</td> <!-- FIXED: colspan -->
                                </tr>
                            ";
                        } else {
                            while ($row = mysqli_fetch_array($res)) {
                                $output .= "
                                    <tr>
                                        <td>".$row['PatientID']."</td>
                                        <td>".$row['Patient_No']."</td>
                                        <td>".$row['fullName']."</td>
                                        <td>".$row['email']."</td>
                                        <td>".$row['gender']."</td>
                                        <td>".$row['phone_number']."</td>
                                        <td>".$row['DOB']."</td>
                                        <td>".$row['country']."</td>
                                        <td>".$row['address']."</td>
                                        <td>".$row['Insurance_Provider']."</td>
                                        <td>".$row['Medical_History']."</td>
                                        <td>".$row['Current_Medications']."</td>
                                        <td>".$row['Allergies']."</td>
                                        <td>".$row['E_Contact_Name']."</td>
                                        <td>".$row['E_Contact_relationship']."</td>
                                        <td>".$row['E_Contact_phone']."</td>
                                        <td>".$row['data_reg']."</td>                                
                                        <td>
                                            <a href='doctor-view.php?tab_id=$tab_id&id={$row['PatientID']}' class='d-grid gap-2 d-md-flex justify-content-center'>
                                                <button class='btn btn-info me-md-2'>VIEW</button>
                                            </a>
                                        </td>

                                    </tr> <!-- FIXED: Closing tr -->
                                ";
                            }
                        }
                    
                        $output .= "
                                </tbody>
                            </table>
                            </div>
                        ";
                        echo $output;
                            ?>
                        </div>
                    </div>
                </div>
        
        </div>
    </div>
</div>

</body>
</html>