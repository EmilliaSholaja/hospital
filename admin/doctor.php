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
    <title>Total Doctors</title>
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

<div class="main1 d-flex">
    
    <div class="row w-100">
       
            <div class="col-md-2">
                <?php include("../admin/sidenav.php") ?>
            </div>
            <div class="col-md-10 main--content">
                        <h5 class="text-center">Total Doctors</h5>
                        <?php
                            $query = "SELECT * FROM doctor WHERE status ='APPROVED' ORDER BY data_reg ASC";
                            $res = mysqli_query($connect, $query);

                            $output = "
                            <div class='table-responsive'>  <!-- ADD THIS -->
                                <table class='table table-bordered'>
                                    <thead class='thead-dark'>  <!-- Bootstrap styling for better appearance -->
                                        <tr>
                                            <th>ID</th>
                                            <th>Doctor Hospital ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Phone Number</th>
                                            <th>Date Of Birth</th>
                                            <th>Country</th>
                                            <th>Specialization</th>
                                            <th>Medicial Degree</th>
                                            <th>Years of Experience</th>
                                            <th>Current Hospital</th>
                                            <th>Medicial License Number</th>
                                            <th>Salary</th>
                                            <th>Date Registered</th>
                                            <th class='text-center'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        ";
                
                
                    if (mysqli_num_rows($res) < 1) {
                        $output .= "
                            <tr>
                                <td colspan='14' class='text-center'>No Doctors....</td> <!-- FIXED: colspan -->
                            </tr>
                        ";
                    } else {
                        while ($row = mysqli_fetch_array($res)) {
                            $output .= "
                                <tr>
                                    <td>".$row['DoctorID']."</td>
                                    <td>".$row['Doctor_hospital_id']."</td>
                                    <td>".$row['fullName']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['gender']."</td>
                                    <td>".$row['phone_number']."</td>
                                    <td>".$row['date_of_birth']."</td>
                                    <td>".$row['country']."</td>
                                    <td>".$row['specialization']."</td>
                                    <td>".$row['medical_degree']."</td>
                                    <td>".$row['Year_of_experience']."</td>
                                    <td>".$row['Current_Hospital']."</td>
                                    <td>".$row['Medical_License_Number']."</td>
                                    <td>".$row['salary']."</td>
                                    <td>".$row['data_reg']."</td>                                
                                    <td>
                                        <a href='edit.php?tab_id=$tab_id&id={$row['DoctorID']}' class='d-grid gap-2 d-md-flex justify-content-center'>
                                            <button class='btn btn-info me-md-2'>EDIT</button>
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

</body>
</html>