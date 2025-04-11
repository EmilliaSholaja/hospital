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
    <title>Admin Profile</title>
</head>
<body>
    <?php 
        include("../include/header.php");
        include("../include/connection.php");

        $ad = $_SESSION['admin'][$tab_id];
        $query = "SELECT * FROM admin WHERE admin_hospital_id ='$ad'";
        $res = mysqli_query($connect, $query);

        $row = mysqli_fetch_assoc($res);
        if ($row) {
            $hospital_id = $row['admin_hospital_id'];
            $profile = $row['profile'];

        } else {
            $hospital_id = "Unknown";
            $profile = "../admin/img/default.jpg"; // Set a default image if missing
        }
    ?>

<div class="main1 d-flex">
    <div class="row w-100">
        <div class="col-md-2">
            <?php include("../admin/sidenav.php") ?>
        </div>
        <div class="col-md-10 main--content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4><?php echo $hospital_id; ?> Profile</h4>

                        <?php
                            $message = ""; // Initialize message variable

                            if (isset($_POST['update'])) {
                                $profile_name = $_FILES['profile']['name'];
                                $profile_tmp = $_FILES['profile']['tmp_name'];

                                // Check if a file is uploaded
                                if (!empty($profile_name)) {
                                    // Secure filename
                                    $profile_name = mysqli_real_escape_string($connect, $profile_name);
                                    $upload_path = "../admin/img/" . $profile_name;

                                    // Get the old profile image from the database
                                    $query_old = "SELECT profile FROM admin WHERE admin_hospital_id = '$ad'";
                                    $result_old = mysqli_query($connect, $query_old);
                                    $row_old = mysqli_fetch_assoc($result_old);
                                    $old_image = $row_old['profile'];

                                    // Delete the old image (if it exists)
                                    if (!empty($old_image) && file_exists("../admin/img/" . $old_image)) {
                                        unlink("../admin/img/" . $old_image);
                                    }

                                    // Move the new file to the correct directory
                                    if (move_uploaded_file($profile_tmp, $upload_path)) {
                                        // Update the database with the new image
                                        $query = "UPDATE admin SET profile ='$profile_name' WHERE admin_hospital_id = '$ad'";
                                        $result = mysqli_query($connect, $query);
                                        
                                        if ($result) {
                                            $message = "<div class='alert alert-success' id='alert'>Profile Updated Successfully!</div>";
                                            $_SESSION['profile'] = $profile_name; // Update session variable
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
                        ?>

                        <!-- Display Message -->
                        <?php echo $message; ?>

                        <!-- Profile Upload Form -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- Profile Image Display -->
                            <?php
                                echo "
                                    <img src='../admin/img/$profile' class='col-md-12' style='height: 250px; border: 2px solid #4e34b6; border-radius: 50%; width: 250px;'>
                                ";
                            ?>
                            <br> <br>
                            <div class="form-group">
                                <label for="profile">UPDATE PROFILE</label>
                                <input type="file" name="profile" class="form-control" autocomplete="off">
                            </div>
                            <input type="hidden" name="tab_id" value="<?php echo $tab_id; ?>"> <!-- Hidden input for tab_id -->
                            <br>
                            <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                        </form>

                    </div>
                    <div class="col-md-6">

                        <?php
                            $message = ""; // To store success message
                            if (isset($_POST['change'])) {
                                $adminName = $_POST['admin_name'];
                            
                                if (!empty($adminName)) {
                                    $query = "UPDATE admin SET admin_name = '$adminName' WHERE admin_hospital_id = '$ad'";
                                    $res = mysqli_query($connect, $query);
                            
                                    if ($res) {
                                        $_SESSION['message'] = "<div class='alert alert-success' id='name_success_alert'>Name Updated Successfully!</div>";
                                        // Force reload to reflect changes
                                        echo "<meta http-equiv='refresh' content='0'>";
                                        exit();
                                    } else {
                                        $_SESSION['message'] = "<div class='alert alert-danger' id='name_error_alert'>Error updating name.</div>";
                                    }
                                }
                            }
                        ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <h4 class="text-center my-4">Change Full Name</h4>
                                <?php
                                    if (isset($_SESSION['message'])) {
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']); // Clear message after displaying
                                    }
                                ?>
                                <input type="text" name="admin_name" class="form-control" autocomplete="off" placeholder="Enter New Name">
                            </div>
                            <input type="hidden" name="tab_id" value="<?php echo $tab_id; ?>"> <!-- Hidden input for tab_id -->
                            <br>
                            <input type="submit" name="change" value="CHANGE NAME" class="btn btn-success">
                        </form>
                        <br>

                        <?php
                            $success_message = ""; // Initialize success message
                            $error = array(); // Initialize error array

                            if (isset($_POST['update_pass'])) {
                                $old_pass = $_POST['old_pass'];
                                $new_pass = $_POST['new_pass'];
                                $con_pass = $_POST['con_pass'];

                                // Fetch current password
                                $old = mysqli_query($connect, "SELECT password FROM admin WHERE admin_hospital_id = '$ad'");
                                $row = mysqli_fetch_array($old);
                                $db_pass = $row['password']; // This is the stored password (plain text)

                                if ($old_pass !== $db_pass) { // Directly compare plain text passwords
                                    $error['p'] = "Invalid Old Password";
                                } elseif (empty($new_pass) || empty($con_pass)) {
                                    $error['p'] = "Please fill in all fields";
                                } elseif ($new_pass !== $con_pass) {
                                    $error['p'] = "New Passwords do not match";
                                } else {
                                    // Store the new password directly (consider hashing for better security)
                                    $query = "UPDATE admin SET password = '$new_pass' WHERE admin_hospital_id = '$ad'";

                                    if (mysqli_query($connect, $query)) {
                                        $success_message = "<div class='alert alert-success' id='success_alert'>Password Updated Successfully!</div>";
                                    } else {
                                        $error['p'] = "Error updating password.";
                                    }
                                }
                            }

                            $show = isset($error['p']) ? "<h5 class='text-center alert alert-danger' id='error_alert'>{$error['p']}</h5>" : "";
                        ?>

                        <form action="" method="post">
                            <h4 class="text-center my-4">Change Password</h4>
                            <div>
                                <?php echo $show;?>
                                <?php echo $success_message;?>
                            </div>
                            <div class="form-group">
                                <label for="old_pass">Old Password</label>
                                <input type="password" name="old_pass" class="form-control" autocomplete="off" placeholder="Enter Old Password">
                            </div>
                        
                            <div class="form-group">
                                <label for="new_pass">New Password</label>
                                <input type="password" name="new_pass" class="form-control" autocomplete="off" placeholder="Enter New Password">
                            </div>
                        
                            <div class="form-group">
                                <label for="con_pass">Confirm Password</label>
                                <input type="password" name="con_pass" class="form-control" autocomplete="off" placeholder="Re-enter Password">
                            </div>
                            <input type="hidden" name="tab_id" value="<?php echo $tab_id; ?>"> <!-- Hidden input for tab_id -->
                            <br>
                            <input type="submit" name="update_pass" value="CHANGE PASSWORD" class="btn btn-info">
                        </form>

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

</script>   
</body>
</html>