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
    <title>Admin's Dashboard</title>
    <style>
        .bg-lavender {
            background-color: #e6e6fa!important;
            color: #3a278f !important;
        }
    </style>
</head>

<body>
    <?php 
    include("../include/header.php");
    include("../include/connection.php");
    // The include statement includes and evaluates the specified file.
    ?>

   
<div class="main1 d-flex">
    <div class="row w-100">
        <div class="col-md-2">
            <?php include("../admin/sidenav.php") ?>
        </div>
        <div class="col-md-10 main--content">
        <div class="container-fluid">

                    <h4 class="my-2" >Admin Dashboard</h4>
                

                    <div class="col-md-12 my-1">
                        <div class="row">
                            <div class="col-md-3 info mx-2 bg-success" style="height:200px;">
                                <div class="col-md-12">
                                    <a href="../admin/admin.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <?php 
                                                    $ad = mysqli_query($connect,"SELECT * FROM admin");
                                                    $num = mysqli_num_rows($ad);
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $num; ?></h5>
                                                <h5 class="text-white">Total</h5>
                                                <h5 class="text-white">Admin</h5>
                                            </div>
                                            <div class="col-md-4">
                                            <i class="fa-solid fa-3x fa-users-gear my-4" style="color: #fff;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                           
        
    
                            <div class="col-md-3 mx-2 bg-info" style="height:200px;">
                                <div class="col-md-12">
                                <a href="../admin/doctor.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <?php 
                                                    $doctor = mysqli_query($connect,"SELECT * FROM doctor WHERE status = 'APPROVED'");
                                                    $num2 = mysqli_num_rows($doctor);
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $num2; ?></h5>
                                                <h5 class="text-white">Total</h5>
                                                <h5 class="text-white">Doctors</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-3x fa-user-doctor my-4" style="color: #fff;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 mx-2 bg-warning" style="height:200px;">
                                <div class="col-md-12">
                                    <a href="../admin/patient.php?tab_id=<?php echo $tab_id; ?>">
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
                                                <i class="fa-solid fa-3x fa-bed-pulse my-4" style="color: #fff;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 mx-2 my-2 bg-danger" style="height:200px;">
                                <div class="col-md-12">
                                    <a href="../admin/report.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                            <?php 
                                                    $report= mysqli_query($connect,"SELECT * FROM report");
                                                    $num4 = mysqli_num_rows($report);
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $num4; ?></h5>
                                                <h5 class="text-white">Total</h5>
                                                <h5 class="text-white">Reports</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-3x fa-flag my-4" style="color: #fff;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 mx-2 my-2 bg-warning" style="height:200px;">
                                <div class="col-md-12">
                                    <a href="../admin/job-request.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                            <?php 
                                                    $job = mysqli_query($connect,"SELECT * FROM doctor WHERE status = 'PENDING'");
                                                    $num1 = mysqli_num_rows($job);
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo $num1; ?></h5>
                                                <h5 class="text-white">Total</h5>
                                                <h5 class="text-white">Job Requests</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-3x fa-book-open my-4" style="color: #fff;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-3 mx-2 my-2 bg-success" style="height:200px;">
                                <div class="col-md-12">
                                    <a href="../admin/income.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                            <?php 
                                                    $income = mysqli_query($connect,"SELECT sum(amount_paid) as profit FROM income");
                                                    $row = mysqli_fetch_array($income);
                                                    $inc = $row['profit']
                                                ?>
                                                <h5 class="my-2  text-white" style="font-size: 30px;"><?php echo '$'.$inc; ?></h5>
                                                <h5 class="text-white">Total</h5>
                                                <h5 class="text-white">Income</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-3x fa-money-check-dollar my-4" style="color: #fff;"></i>
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
    </div>
</body>
</html>