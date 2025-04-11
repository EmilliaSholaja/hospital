<?php 
session_start();
error_reporting(0);

$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'][$tab_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile Page</title>
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 922px){
            .table-container {
                max-height: 300px;
                overflow-y: auto;
            }
        }
    </style>
</head>
<body>
<?php 
    include("../include/header.php"); 
    include("../include/connection.php");

    $query = "SELECT * FROM doctor WHERE Doctor_hospital_id ='$doctor_id'";
    $res = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $hospital_id = $row['Doctor_hospital_id'];
        $profile = !empty($row['profile']) ? $row['profile'] : 'doctor_default.jpg';
    } else {
        $hospital_id = "Unknown";
        $profile = "../doctor/img/doctor_default.jpg";
    }
?>

<div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("../doctor/doctor-sidenav.php"); ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="my-2"><?php echo $hospital_id; ?> Profile</h4>
                                <?php
                                    $message = "";
                                    if (isset($_POST['update'])) {
                                        $profile_name = $_FILES['profile']['name'];
                                        $profile_tmp = $_FILES['profile']['tmp_name'];

                                        if (!empty($profile_name)) {
                                            $profile_name = mysqli_real_escape_string($connect, $profile_name);
                                            $upload_path = "../doctor/img/" . $profile_name;

                                            $query_old = "SELECT profile FROM doctor WHERE Doctor_hospital_id = '$doctor_id'";
                                            $result_old = mysqli_query($connect, $query_old);
                                            $row_old = mysqli_fetch_assoc($result_old);
                                            $old_image = $row_old['profile'];

                                            if (!empty($old_image) && file_exists("../doctor/img/" . $old_image)) {
                                                unlink("../doctor/img/" . $old_image);
                                            }

                                            if (move_uploaded_file($profile_tmp, $upload_path)) {
                                                $query = "UPDATE doctor SET profile ='$profile_name' WHERE Doctor_hospital_id = '$doctor_id'";
                                                $result = mysqli_query($connect, $query);

                                                if ($result) {
                                                    $message = "<div class='alert alert-success' id='alert'>Profile Updated Successfully!</div>";
                                                    $_SESSION['profile'] = $profile_name;
                                                    echo "<meta http-equiv='refresh' content='0'>";
                                                } else {
                                                    $message = "<div class='alert alert-danger' id='alert'>Error updating profile.</div>";
                                                }
                                            } else {
                                                $message = "<div class='alert alert-danger' id='alert'>Failed to upload image.</div>";
                                            }
                                        } else {
                                            $message = "<div class='alert alert-warning' id='alert'>No file selected.</div>";
                                        }
                                    }
                                    echo $message;
                                ?>

                                <form action="" method="post" enctype="multipart/form-data">
                                    <img src='../doctor/img/<?php echo $profile; ?>' class='col-md-12' style='height: 200px; border: 2px solid #4e34b6; border-radius: 50%; width: 200px;'><br><br>
                                    <div class="form-group">
                                        <label for="profile">UPDATE PROFILE</label>
                                        <input type="file" name="profile" class="form-control" autocomplete="off">
                                    </div>
                                    <br>
                                    <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                                </form>

                                <div class="my-3 table-container">
                                    <table class="table table-responsive table-bordered">
                                        <thead><th colspan="2" class="text-center">Details</th></thead>
                                        <tbody>
                                            <tr><td>Doctor Hospital ID</td><td><?php echo $row['Doctor_hospital_id']; ?></td></tr>
                                            <tr><td>Full Name</td><td><?php echo $row['fullName']; ?></td></tr>
                                            <tr><td>Email</td><td><?php echo $row['email']; ?></td></tr>
                                            <tr><td>Gender</td><td><?php echo $row['gender']; ?></td></tr>
                                            <tr><td>Phone Number</td><td><?php echo $row['phone_number']; ?></td></tr>
                                            <tr><td>Date Of Birth</td><td><?php echo $row['date_of_birth']; ?></td></tr>
                                            <tr><td>Country</td><td><?php echo $row['country']; ?></td></tr>
                                            <tr><td>Specialization</td><td><?php echo $row['specialization']; ?></td></tr>
                                            <tr><td>Medical Degree</td><td><?php echo $row['medical_degree']; ?></td></tr>
                                            <tr><td>Year Of Experience</td><td><?php echo $row['Year_of_experience']; ?></td></tr>
                                            <tr><td>Current Hospital</td><td><?php echo $row['Current_Hospital']; ?></td></tr>
                                            <tr><td>Medical License Number</td><td><?php echo $row['Medical_License_Number']; ?></td></tr>
                                            <tr><td>Salary</td><td><?php echo $row['salary']; ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Name Change -->
                                <?php
                                    if (isset($_POST['change_name'])) {
                                        $doctorName = $_POST['doctorName'];
                                        if (!empty($doctorName)) {
                                            $query = "UPDATE doctor SET fullName = '$doctorName' WHERE Doctor_hospital_id = '$doctor_id'";
                                            $res = mysqli_query($connect, $query);
                                            if ($res) {
                                                $_SESSION['message'] = "<div class='alert alert-success' id='name_success_alert'>Name Updated Successfully!</div>";
                                                echo "<meta http-equiv='refresh' content='0'>";
                                                exit();
                                            } else {
                                                $_SESSION['message'] = "<div class='alert alert-danger' id='name_error_alert'>Error updating name.</div>";
                                            }
                                        }
                                    }

                                    if (isset($_SESSION['message'])) {
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                    }
                                ?>
                                <h5 class="text-center my-2">Change Name</h5>
                                <form action="" method="post">
                                    <label for="doctorName">Change Name</label>
                                    <input type="text" name="doctorName" autocomplete="off" class="form-control" placeholder="Enter Name">
                                    <br>
                                    <input type="submit" value="Change Name" name="change_name" class="btn btn-success">
                                </form>
                                <br><br>

                                <!-- Password Change -->
                                <?php
                                 // Check if there's an error message stored in the session
                                    
                                $error = [];
                                $success_message = "";
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
                                        $old_password = $_POST['old_password'];
                                        $new_password = $_POST['new_password'];
                                        $con_password = $_POST['con_password'];

                                        $check = mysqli_query($connect, "SELECT password FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
                                        $row = mysqli_fetch_array($check);
                                        $db_password = $row['password'];
                                        

                                        if ($old_password !== $db_password) {
                                            $error['p'] = "Invalid Old Password";
                                        } elseif (empty($new_password) || empty($con_password)) {
                                            $error['p'] = "Please fill in all fields";
                                        } elseif ($new_password !== $con_password) {
                                            $error['p'] = "New Passwords do not match";
                                        } else {
                                            $query = "UPDATE doctor SET password = '$new_password' WHERE Doctor_hospital_id = '$doctor_id'";
                                            if (mysqli_query($connect, $query)) {
                                                $success_message = "<div class='alert alert-success' id='success_alert'>Password Updated Successfully!</div>";
                                            } else {
                                                $error['p'] = "Error updating password.";
                                            }
                                            
                                        }
                                      
                                    }

                                    echo isset($error['p']) ? "<h5 class='text-center alert alert-danger'>{$error['p']}</h5>" : "";
                                    echo $success_message;

                                    if (isset($_SESSION['error'])) {
                                        $error['p'] = $_SESSION['error'];
                                        unset($_SESSION['error']); // Clear the error message after it's displayed
                                    }

                                    // Check if there's a success message stored in the session
                                    if (isset($_SESSION['message'])) {
                                        $success_message = $_SESSION['message'];
                                        unset($_SESSION['message']); // Clear the success message after it's displayed
                                    }

                                  
                                ?>

                                <h5 class="text-center my-2">Change Password</h5>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_password" class="form-control" placeholder="Re-enter Password" autocomplete="off">
                                    </div>
                                    <br>
                                    <input type="submit" name="update_password" value="CHANGE PASSWORD" class="btn btn-info">
                                </form>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        var alertBox = document.getElementById("alert");
        if (alertBox) {
            alertBox.style.display = "none";
        }
    }, 7000);

    setTimeout(function() {
        var successAlert = document.getElementById("name_success_alert");
        var errorAlert = document.getElementById("name_error_alert");
        if (successAlert) successAlert.style.display = "none";
        if (errorAlert) errorAlert.style.display = "none";
    }, 7000);

    setTimeout(function() {
        var successAlert = document.getElementById("success_alert");
        var errorAlert = document.getElementById("error_alert");
        if (successAlert) successAlert.style.display = "none";
        if (errorAlert) errorAlert.style.display = "none";
    },7000);
</script> 
</body>
</html>