<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (empty($tab_id)) {
    header("Location: ../patient-login.php");
    exit();
}

include("../include/connection.php");

$patient_id = $_SESSION['patient'][$tab_id];

// Fetch the patient's details from the database using the patient_id (assuming tab_id is the patient_id)
$query = "SELECT Patient_No, fullName FROM patient WHERE Patient_No = '$patient_id'";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
    // Fetch the patient details
    $row = mysqli_fetch_assoc($result);
    $patient_no = $row['Patient_No'];
    $patient_full_name = $row['fullName'];
} else {
    // Handle case if no patient found (for example, redirect or show error)
    echo "<script>alert('Patient not found.')</script>";
    exit();
}

// Retrieve doctor details
$query_doctor = "SELECT Doctor_hospital_id, fullName, specialization FROM doctor WHERE status = 'APPROVED'";
$result_doctor = mysqli_query($connect, $query_doctor);

// Handle form submission to create an appointment
if (isset($_POST['book'])) {
    $doctor_id = $_POST['doctor_id'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_type = $_POST['appointment_type'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $sym = $_POST['sym'];
    $room_number = $_POST['room_number'];
    $notes = $_POST['notes'];

    // Insert the appointment into the database
    $insert_query = "INSERT INTO appointment (patient_name, patient_id, doctor_id, doctor_name, appointment_type, appointment_date, appointment_time, room_number, symptoms, notes, status) 
                     VALUES ('$patient_full_name', '$patient_no', '$doctor_id', '$doctor_name', '$appointment_type', '$appointment_date', '$appointment_time', '$room_number', '$sym', '$notes', 'PENDING')";

    if (mysqli_query($connect, $insert_query)) {
        echo "<script>alert('Appointment booked successfully!')</script>";
        // After successful insertion, redirect to the same page to prevent form resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF'] . "?tab_id=" . $tab_id);
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "')</script>";
    }
}
// Handle cancel appointment request
if (isset($_POST['cancel'])) {
    $cancel_id = $_POST['cancel_id'];
    $now = date('Y-m-d H:i:s');
    $cancel_query = "UPDATE appointment SET status = 'CANCELLED', cancelled_at='$now' WHERE appointment_id = '$cancel_id' AND status = 'PENDING'";
    
    if (mysqli_query($connect, $cancel_query)) {
        echo "<script>alert('Appointment cancelled successfully.');</script>";
        header("Location: " . $_SERVER['PHP_SELF'] . "?tab_id=" . $tab_id);
        exit();
    } else {
        echo "<script>alert('Failed to cancel appointment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
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
    <?php include("../include/header.php"); ?>
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../patient/patient-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Book Appointment</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 jumbotron">
                                <form action="" method="post">
                                    <!-- Appointment Type Dropdown -->
                                    <label for="appointment_type">Select Appointment Type:</label>
                                    <select class="form-control" id="appointment_type" name="appointment_type" required>
                                        <option value="" disabled selected>Select Appointment Type</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Emergency">Emergency</option>
                                        <option value="Follow-up">Follow-up</option>
                                        <option value="Checkup">Checkup</option>
                                    </select>
                                    <br>

                                    <!-- Doctor Selection Dropdown -->
                                    <label for="doctor">Select Doctor:</label>
                                    <select class="form-control" id="doctor" name="doctor_id" required>
                                        <option value="" disabled selected>Select a Doctor</option>
                                        <?php
                                        // Populate the dropdown with doctors from the database
                                        while ($row = mysqli_fetch_assoc($result_doctor)) {
                                            $doctor_id = $row['Doctor_hospital_id'];
                                            $doctor_name = $row['fullName'];
                                            $specialization = $row['specialization'];
                                            echo "<option value='$doctor_id' data-doctor-name='$doctor_name'>$doctor_name - $specialization</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" id="doctor_name" name="doctor_name">  <!-- Hidden field for doctor name -->
                                    <br>

                                    <!-- Appointment Date -->
                                    <label for="appointment_date">Appointment Date:</label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                                    <br>

                                    <!-- Appointment Time -->
                                    <label for="appointment_time">Appointment Time:</label>
                                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                                    <br>

                                    <!-- Room Number -->
                                    <label for="room_number">Room Number:</label>
                                    <input type="text" class="form-control" id="room_number" placeholder="Optional" name="room_number" >
                                    <br>

                                    <!-- Symptoms -->
                                    <label for="sym">Symptoms:</label>
                                    <input type="text" class="form-control" id="sym" name="sym" required>
                                    <br>

                                    <!-- Notes -->
                                    <label for="notes">Notes:</label>
                                    <textarea class="form-control" id="notes" placeholder="Optional" name="notes"></textarea>
                                    <br>

                                    <button type="submit" name="book" class="btn btn-primary">Book Appointment</button>
                                </form>

                                <hr>
                                    <h6 class="text-center">Previous Appointments</h6>
                                    <div class="table-responsive">
                                        <table class="table table-responsive table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Doctor</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Room</th>
                                                    <th>Symptoms</th>
                                                    <th>Notes</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            <?php
                                            // Fetch past appointments for this patient
                                            $appointment_query = "SELECT * FROM appointment WHERE patient_id = '$patient_no' ORDER BY appointment_date DESC, appointment_time DESC";
                                            $appointment_result = mysqli_query($connect, $appointment_query);

                                            if (mysqli_num_rows($appointment_result) > 0) {
                                                $counter = 1;
                                                while ($appointment = mysqli_fetch_assoc($appointment_result)) {
                                                    $appointment_id = $appointment['appointment_id']; // Assuming your appointment table has a unique id column
                                                
                                                    echo "<tr>
                                                        <td>{$counter}</td>
                                                        <td>{$appointment['doctor_name']}</td>
                                                        <td>{$appointment['appointment_type']}</td>
                                                        <td>{$appointment['appointment_date']}</td>
                                                        <td>{$appointment['appointment_time']}</td>
                                                        <td>" . (!empty($appointment['room_number']) ? $appointment['room_number'] : "<i style='color: #333;'>Optional</i>") . "</td>
                                                        <td>{$appointment['symptoms']}</td>
                                                        <td>" . (!empty($appointment['notes']) ? $appointment['notes'] : "<i style='color: #333;'>Optional</i>") . "</td>
                                                       <td>{$appointment['status']}</td>
                                                        
                                                        <td>";
                                                        
                                                        if ($appointment['status'] === 'PENDING'|| $appointment['status'] === 'CONFIRMED') {
                                                            echo "<form method='post' style='display:inline;'>
                                                                    <input type='hidden' name='cancel_id' value='{$appointment['appointment_id']}'>
                                                                    <button type='submit' name='cancel' class='btn btn-danger btn-sm'>Cancel</button>
                                                                </form>";
                                                        } elseif ($appointment['status'] === 'CANCELLED') {
                                                            echo "<span class='text-muted'>Cancelled</span>";
                                                        }

                                                    echo "</td>
                                                    </tr>";
                                                    $counter++;

                                                }
                                            } else {
                                                echo "<tr><td colspan='10' class='text-center'>No previous appointments found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>


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