<?php
session_start();
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
    <title>Patient's Dashboard</title>
</head>
<body>
    <?php 
        include("../include/header.php");
        include("../include/connection.php");
    ?><div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("../patient/patient-sidenav.php") ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    <h5 class="text-center">Patient's Dashboard</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 my-2 bg-success mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/patient-profile.php?tab_id=<?php echo $tab_id; ?>">
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
                            <div class="col-md-3 my-2 bg-info mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/appointment.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">Book Appointment</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-calendar fa-3x my-4" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 bg-warning mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/patient-invoice.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">My Invoice</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-file-invoice-dollar fa-3x my-4"style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- New Sections -->
                            <div class="col-md-3 my-2 bg-primary mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/medical-record.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">Medical Records</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-notes-medical fa-3x my-4" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 bg-danger mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/prescription.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">Prescriptions</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-pills fa-3x my-4" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 bg-secondary mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/lab-result.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">Lab Results</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-vials fa-3x my-4" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 bg-dark mx-2" style="height: 200px;">
                                <div class="col-md-12">
                                    <a href="../patient/health-tips.php?tab_id=<?php echo $tab_id; ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="text-white my-4">Health Tips</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa-solid fa-heartbeat fa-3x my-4" style="color: white;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                $query_doctor = "SELECT Doctor_hospital_id, fullName FROM doctor WHERE status = 'APPROVED'";
                $result_doctor = mysqli_query($connect, $query_doctor);
                
if (isset($_POST['send'])) {
    $title  = $_POST['title'];
    $message  = $_POST['message'];
    $doctor_name  = $_POST['doctor_name'];
    $form_tab_id = $_POST['tab_id'] ?? '';

    $error = array();

    if (empty($title)) {
        $error['c'] = "Enter the Title of The Report";
    } elseif (empty($message)) {
        $error['c'] = "Enter the Message"; 
    } elseif (empty($doctor_name)) {
        $error['c'] = "Enter the Doctor's Name";
    } elseif (!isset($_SESSION['patient'][$form_tab_id])) {
        $error['c'] = "Invalid session. Please login again.";
    } else {
        $patient_id = $_SESSION['patient'][$form_tab_id];
        $query = "INSERT INTO report(doctor_name,title, message, PatientNo, date_sent) VALUES('$doctor_name','$title', '$message','$patient_id', NOW())";

        $res = mysqli_query($connect, $query);
        if ($res) {
            mysqli_query($connect, "SET @count = 0;");
            mysqli_query($connect, "UPDATE report SET id = @count := @count + 1;");
            mysqli_query($connect, "ALTER TABLE report MODIFY COLUMN id INT AUTO_INCREMENT;");
            echo "<script>alert('You Have Successfully Sent Your Report');</script>";
            echo "<script>window.location.href = '../patient/patient-index.php?tab_id=" . $form_tab_id . "';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to Send Message');</script>";
        }
    }
}
                    ?>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 jumbotron bg-lavender my-5">
                                <h5 class="text-center my-2">Send A Report</h5>
                               
                                <form action="" method="post">
                                    <input type="hidden" name="tab_id" value="<?php echo htmlspecialchars($tab_id); ?>">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="" autocomplete="off" class="form-control" placeholder="Enter the Title of the Report">
                                    <label for="doctor">Select Doctor:</label>
                                    <select class="form-control" id="doctor" name="doctor_id" required>
                                        <option value="" disabled selected>Select a Doctor</option>
                                        <?php
                                        // Populate the dropdown with doctors from the database
                                        while ($row = mysqli_fetch_assoc($result_doctor)) {
                                            $doctor_name = $row['fullName'];
                                            echo "<option value='$doctor_id' data-doctor-name='$doctor_name'>$doctor_name</option>";
                                        }
                                        ?>
                                    </select>

                                    <label for="message">Message</label>
                                    <textarea name="message" id="" autocomplete="off" class="form-control" placeholder="Enter Message"></textarea>
                                  
                                    <input type="submit" value="Send Report" name="send" class="btn btn-success my-2">
                                </form>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Automatically set doctor name when the doctor is selected
        $('#doctor').change(function() {
            var doctor_name = $("option:selected", this).data('doctor-name');
            $('#doctor_name').val(doctor_name);  // Set doctor name in hidden field
        });
    </script>

</body>
</html>