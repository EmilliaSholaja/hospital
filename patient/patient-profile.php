<?php 
  
    session_start();
    error_reporting(0);
    $tab_id = $_GET['tab_id'] ?? '';
    
    if (!isset($_SESSION['patient'][$tab_id])) {
        header("Location: ../patient-login.php");
        exit();
    }
    
    // You can access the logged-in admin ID using:
    $patient_id = $_SESSION['patient'][$tab_id];
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile Page</title>
    <style>
        .table-container {
            max-height: 400px; /* Adjust as needed */
            overflow-y: auto;
        }

        @media (max-width: 922px){
            .table-container {
            max-height: 300px; /* Adjust as needed */
            overflow-y: auto;
        }
        }
    </style>
</head>
<body>
<?php 
    include("../include/header.php"); 
    include("../include/connection.php");

    $query = "SELECT * FROM patient WHERE Patient_No='$patient_id'";
    $res = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $hospital_id = $row['Patient_No'];
        $profile = !empty($row['profile']) ? $row['profile'] : 'patient_default.jpg';
    } else {
        $hospital_id = "Unknown";
        $profile = "../patient/img/patient_default.jpg";
    }
?>

    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../patient/patient-sidenav.php"); ?>
                </div>
                <div class="col-md-10 main--content">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="my-2">My Profile</h4>

                                    <?php
                                    $message = "";
                                    if (isset($_POST['update'])) {
                                        $profile_name = $_FILES['profile']['name'];
                                        $profile_tmp = $_FILES['profile']['tmp_name'];

                                        if (!empty($profile_name)) {
                                            $profile_name = mysqli_real_escape_string($connect, $profile_name);
                                            $upload_path = "../patient/img/" . $profile_name;

                                            $query_old = "SELECT profile FROM patient WHERE Patient_No = '$patient_id'";
                                            $result_old = mysqli_query($connect, $query_old);
                                            $row_old = mysqli_fetch_assoc($result_old);
                                            $old_image = $row_old['profile'];

                                            if (!empty($old_image) && file_exists("../patient/img/" . $old_image)) {
                                                unlink("../patient/img/" . $old_image);
                                            }

                                            if (move_uploaded_file($profile_tmp, $upload_path)) {
                                                $query = "UPDATE patient SET profile ='$profile_name' WHERE Patient_No = '$patient_id'";
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

                                 



                                    <!-- Profile Upload Form -->
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <!-- Profile Image Display -->
                                        <?php
                                            echo "
                                                <img src='../patient/img/$profile' class='col-md-12' style='height: 200px; border: 2px solid #4e34b6; border-radius: 50%; width: 200px;'>
                                            ";
                                        ?>
                                        <br> <br>
                                        <div class="form-group">
                                            <label for="profile">UPDATE PROFILE</label>
                                            <input type="file" name="profile" class="form-control" autocomplete="off">
                                        </div>
                                        <br>
                                        <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                                    </form>
                                    
                                    <div class="my-3 table-container">
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
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                                <div class="col-md-6">
    <?php
        // Name Change Handler
        if (isset($_POST['change_name'])) {
            $form_tab_id = $_POST['tab_id'] ?? '';
            if (!isset($_SESSION['patient'][$form_tab_id])) {
                exit("Invalid session. Please log in again.");
            }
            $ad = $_SESSION['patient'][$form_tab_id];
            $patientName = $_POST['patientName'];

            if (!empty($patientName)) {
                $query = "UPDATE patient SET fullName = '$patientName' WHERE Patient_No = '$ad'";
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
    ?>
    <h5 class="text-center my-2">Change Name</h5>
    <?php 
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
    <form action="" method="post">
        <input type="hidden" name="tab_id" value="<?php echo htmlspecialchars($tab_id); ?>">
        <label for="doctorName">Change Name</label>
        <input type="text" name="patientName" autocomplete="off" class="form-control" placeholder="Enter Name">
        <br>
        <input type="submit" value="Change Name" name="change_name" class="btn btn-success">
    </form>
    <br><br>

    <?php
        // Password Change Handler
        $success_message = "";
        $error = array();

        if (isset($_POST['update_password'])) {
            $form_tab_id = $_POST['tab_id'] ?? '';
            if (!isset($_SESSION['patient'][$form_tab_id])) {
                exit("Invalid session. Please log in again.");
            }
            $ad = $_SESSION['patient'][$form_tab_id];

            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $con_password = $_POST['con_password'];

            $old = mysqli_query($connect, "SELECT password FROM patient WHERE Patient_No = '$ad'");
            $row = mysqli_fetch_array($old);
            $db_password = $row['password'];

            if ($old_password !== $db_password) {
                $error['p'] = "Invalid Old Password";
            } elseif (empty($new_password) || empty($con_password)) {
                $error['p'] = "Please fill in all fields";
            } elseif ($new_password !== $con_password) {
                $error['p'] = "New Passwords do not match";
            } else {
                $query = "UPDATE patient SET password = '$new_password' WHERE Patient_No = '$ad'";
                if (mysqli_query($connect, $query)) {
                    $success_message = "<div class='alert alert-success' id='success_alert'>Password Updated Successfully!</div>";
                } else {
                    $error['p'] = "Error updating password.";
                }
            }
        }

        $show = isset($error['p']) ? "<h5 class='text-center alert alert-danger' id='error_alert'>{$error['p']}</h5>" : "";
    ?>
    <h5 class="text-center my-2">Change Password</h5>
    <div>
        <?php echo $show;?>
        <?php echo $success_message;?>
    </div>
    <form action="" method="post">
        <input type="hidden" name="tab_id" value="<?php echo htmlspecialchars($tab_id); ?>">
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" name="old_password" class="form-control" autocomplete="off" placeholder="Enter Old Password">
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" class="form-control" autocomplete="off" placeholder="Enter New Password">
        </div>
        <div class="form-group">
            <label for="con_password">Confirm Password</label>
            <input type="password" name="con_password" class="form-control" autocomplete="off" placeholder="Re-enter Password">
        </div>
        <br>
        <input type="submit" name="update_password" value="CHANGE PASSWORD" class="btn btn-info">
    </form>
    <br><br>

    <?php
        // Email Change Handler
        if (isset($_POST['change_email'])) {
            $form_tab_id = $_POST['tab_id'] ?? '';
            if (!isset($_SESSION['patient'][$form_tab_id])) {
                exit("Invalid session. Please log in again.");
            }
            $ad = $_SESSION['patient'][$form_tab_id];
            $email = $_POST['email'];

            if (!empty($email)) {
                $query = "UPDATE patient SET email = '$email' WHERE Patient_No = '$ad'";
                $res = mysqli_query($connect, $query);

                if ($res) {
                    $_SESSION['message_email'] = "<div class='alert alert-success' id='email_success_alert'>Email Updated Successfully!</div>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $_SESSION['message_email'] = "<div class='alert alert-danger' id='email_error_alert'>Error updating email.</div>";
                }
            }
        }
    ?>
    <h5 class="text-center my-2">Change Email</h5>
    <?php 
        if (isset($_SESSION['message_email'])) {
            echo $_SESSION['message_email'];
            unset($_SESSION['message_email']);
        }
    ?>
    <form action="" method="post">
        <input type="hidden" name="tab_id" value="<?php echo htmlspecialchars($tab_id); ?>">
        <label for="email">Change Email</label>
        <input type="email" name="email" autocomplete="off" class="form-control" placeholder="Enter New Email">
        <br>
        <input type="submit" value="Change Email" name="change_email" class="btn btn-secondary">
    </form>
    <br><br>

    <?php
        // Phone Number Change Handler
        if (isset($_POST['change_phone'])) {
            $form_tab_id = $_POST['tab_id'] ?? '';
            if (!isset($_SESSION['patient'][$form_tab_id])) {
                exit("Invalid session. Please log in again.");
            }
            $ad = $_SESSION['patient'][$form_tab_id];
            $phone = $_POST['phone'];

            if (!empty($phone)) {
                $query = "UPDATE patient SET phone_number = '$phone' WHERE Patient_No = '$ad'";
                $res = mysqli_query($connect, $query);

                if ($res) {
                    $_SESSION['message_phone'] = "<div class='alert alert-success' id='phone_success_alert'>Phone Number Updated Successfully!</div>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $_SESSION['message_phone'] = "<div class='alert alert-danger' id='phone_error_alert'>Error updating phone number.</div>";
                }
            }
        }
    ?>
    <h5 class="text-center my-2">Change Phone Number</h5>
    <?php 
        if (isset($_SESSION['message_phone'])) {
            echo $_SESSION['message_phone'];
            unset($_SESSION['message_phone']);
        }
    ?>
    <form action="" method="post">
        <input type="hidden" name="tab_id" value="<?php echo htmlspecialchars($tab_id); ?>">
        <label for="phone">Change Phone Number</label>
        <input type="text" name="phone" autocomplete="off" class="form-control" placeholder="Enter New Phone Number">
        <br>
        <input type="submit" value="Change Phone Number" name="change_phone" class="btn btn-dark">
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
       //JavaScript to Remove Message After 7 Seconds 
        setTimeout(function() {
            var alertBox = document.getElementById("alert");
            if (alertBox) {
                alertBox.style.display = "none";
            }
        }, 7000);
            // JavaScript to Remove Name Update Messages After 7 Seconds
        setTimeout(function() {
            var successAlert = document.getElementById("name_success_alert");
            var errorAlert = document.getElementById("name_error_alert");
            if (successAlert) successAlert.style.display = "none";
            if (errorAlert) errorAlert.style.display = "none";
        }, 7000);
        // JavaScript to Remove Success and Error Messages After 7 Seconds
        setTimeout(function() {
            var successAlert = document.getElementById("success_alert");
            var errorAlert = document.getElementById("error_alert");
            if (successAlert) successAlert.style.display = "none";
            if (errorAlert) errorAlert.style.display = "none";
        },7000);
        
        setTimeout(function() {
            var successAlert = document.getElementById("email_success_alert");
            var errorAlert = document.getElementById("email_error_alert");
            if (successAlert) successAlert.style.display = "none";
            if (errorAlert) errorAlert.style.display = "none";
        }, 7000);

        setTimeout(function() {
            var successAlert = document.getElementById("phone_success_alert");
            var errorAlert = document.getElementById("phone_error_alert");
            if (successAlert) successAlert.style.display = "none";
            if (errorAlert) errorAlert.style.display = "none";
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