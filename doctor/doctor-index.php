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
    <title>Doctor's Dashboard</title>
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
                    <div class="container-fluid">
                        <h5 class="text-center">Doctor's Dashboard</h5>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3 my-2 bg-info mx-2" style="height: 200px;">
                                    <div class="col-md-12">
                                        <a href="../doctor/doctor-profile.php?tab_id=<?php echo $tab_id; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5 class="text-white my-4">My Profile</h5>
                                                </div>
                                                <div class="col-md-4">
                                                <i class="fa-regular fa-circle-user fa-3x my-4" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 bg-success mx-2" style="height: 200px;">
                                    <div class="col-md-12">
                                        <a href="../doctor/doctor-patient.php?tab_id=<?php echo $tab_id; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                <?php 
                                                    $patient= mysqli_query($connect,"SELECT * FROM patient");
                                                    $num3 = mysqli_num_rows($patient);
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $num3; ?></h5>
                                                    <h5 class="text-white">Total</h5>
                                                    <h5 class="text-white">Patients</h5>
                                                </div>
                                                <div class="col-md-4">
                                                <i class="fa-solid fa-bed-pulse fa-3x my-4" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 bg-warning mx-2" style="height: 200px;">
                                    <div class="col-md-12">
                                        <a href="../doctor/appointment.php?tab_id=<?php echo $tab_id; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                <?php 
                                                      
                                                      $doctor_name = '';
                                                      
                                                      if ($doctor_id) {
                                                          $doctor_result = mysqli_query($connect, "SELECT fullName FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
                                                          if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
                                                              $row = mysqli_fetch_assoc($doctor_result);
                                                              $doctor_name = $row['fullName'];
                                                          }
                                                      }
                                                      $report_count = 0;

                                                   if (!empty($doctor_name)) {
                                                       $appointment_query = mysqli_query($connect, "SELECT * FROM appointment WHERE doctor_name = '$doctor_name'");
                                                       $appointment_count = mysqli_num_rows($appointment_query);
                                                   }
                                                   ?>
                                                   <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $appointment_count ; ?></h5>
                                                    <h5 class="text-white">Total</h5>
                                                    <h5 class="text-white">Appointment</h5>
                                                </div>
                                                <div class="col-md-4">
                                                <i class="fa-solid fa-calendar fa-3x my-4"style="color: white;"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 my-2 bg-danger mx-2" style="height: 200px;">
                                    <div class="col-md-12">
                                        <a href="../doctor/doctor-report.php?tab_id=<?php echo $tab_id; ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <?php 
                                                      
                                                       $doctor_name = '';
                                                       
                                                       if ($doctor_id) {
                                                           $doctor_result = mysqli_query($connect, "SELECT fullName FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
                                                           if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
                                                               $row = mysqli_fetch_assoc($doctor_result);
                                                               $doctor_name = $row['fullName'];
                                                           }
                                                       }
                                                       $report_count = 0;

                                                    if (!empty($doctor_name)) {
                                                        $report_query = mysqli_query($connect, "SELECT * FROM report WHERE doctor_name = '$doctor_name'");
                                                        $report_count = mysqli_num_rows($report_query);
                                                    }
                                                    ?>
                                                    <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $report_count ; ?></h5>
                                                        <h5 class="text-white">Total</h5>
                                                        <h5 class="text-white">Reports</h5>
                                                </div>
                                                <div class="col-md-4">
                                                <i class="fa-solid fa-file-lines fa-3x my-4" style="color: white;"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>