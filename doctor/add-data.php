<?php
session_start();
$tab_id = $_GET['tab_id'];

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

// You can access the logged-in doctor ID using:
$doctor_id = $_SESSION['doctor'][$tab_id];

include("../include/connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Get patient ID from the URL parameter

    // Fetch patient details from the 'patient' table
    $query1 = "SELECT * FROM patient WHERE PatientID = '$id'";
    $res1 = mysqli_query($connect, $query1);
    
    // If the query returns a result, fetch the patient's details
    if ($row = mysqli_fetch_array($res1)) {
        $patient_n = $row['PatientID'];  // Get the Patient_No from the patient table
    } else {
        echo "<script>alert('Patient not found.');</script>";
        exit();
    }
} else {
    echo "<script>alert('Patient ID is missing.');</script>";
    exit();
}

// Check if form is submitted
if (isset($_POST['submit']) && !empty($_POST['data_type'])) {

    // Check if patient_id is passed via GET (URL)
    if (isset($_GET['id'])) {
        $id = $_GET['id'];  // Get patient ID from the URL parameter

        // Fetch patient details from the 'patient' table
        $query = "SELECT * FROM patient WHERE PatientID = '$id'";
        $res = mysqli_query($connect, $query);
        
        // If the query returns a result, fetch the patient's details
        if ($row = mysqli_fetch_array($res)) {
            $patient_n = $row['PatientID'];  // Get the Patient_No from the patient table
            $patient_no = $row['Patient_No'];  // Get the Patient_No from the patient table
        } else {
            echo "<script>alert('Patient not found.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Patient ID is missing.');</script>";
        exit();
    }

    // Get doctor details
    $doctor_query = mysqli_query($connect, "SELECT fullName FROM doctor WHERE Doctor_hospital_id = '$doctor_id'");
    $doctor_data = mysqli_fetch_array($doctor_query);
    $doctor_no = $doctor_data['fullName'];

    // Rest of the form data
    $data_type = $_POST['data_type'];  // Type of data (medical_record, prescription, or lab_result)
    $record_type = $_POST['record_type'] ?? '';  // Type of medical record
    $description = $_POST['description'] ?? '';  // Description (for medical records)
    $doctor_notes = $_POST['doctor_notes'] ?? '';  // Notes (for medical records)
    $treatment_plan = $_POST['treatment_plan'] ?? '';  // Treatment plan
    $height = $_POST['height'] ?? '';  // Height (for medical records)
    $weight = $_POST['weight'] ?? '';  // Weight (for medical records)
    $medication = $_POST['medication'] ?? '';  // Medication (for prescriptions)
    $dosage = $_POST['dosage'] ?? '';  // Dosage (for prescriptions)
    $instructions = $_POST['instructions'] ?? '';  // Instructions (for prescriptions)
    $test_name = $_POST['test_name'] ?? '';  // Test name (for lab results)
    $test_result = $_POST['test_result'] ?? '';  // Test result (for lab results)
    $doctor_comments = $_POST['doctor_comments'] ?? '';  // Doctor's comments (for lab results)

    // Now insert data depending on the type
    if ($data_type == 'medical_record') {
        // Insert a new medical record with Patient_No
        $insert_query = mysqli_query($connect, "INSERT INTO medical_records (patient_id, date, record_type, description, doctors_notes, treatment_plan, height, weight, doctor_name) 
            VALUES ('$patient_no', NOW(), '$record_type', '$description', '$doctor_notes', '$treatment_plan', '$height', '$weight', '$doctor_no')");

        if ($insert_query) {
            echo "<script>alert('Medical record added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add medical record.');</script>";
        }
    } elseif ($data_type == 'prescription') {
        // Insert a new prescription with Patient_No
        $insert_prescription = mysqli_query($connect, "INSERT INTO prescriptions (patient_id, date, medication, dosage, instructions, doctor_name) 
        VALUES ('$patient_no', NOW(), '$medication', '$dosage', '$instructions', '$doctor_no')");
        
        if ($insert_prescription) {
            echo "<script>alert('Prescription added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add prescription.');</script>";
        }
    } elseif ($data_type == 'lab_result') {
        // Insert a new lab result with Patient_No
        $insert_lab_result = mysqli_query($connect, "INSERT INTO lab_results (patient_id, date, test_name, result, doctors_comments, doctor_name) 
        VALUES ('$patient_no', NOW(), '$test_name', '$test_result', '$doctor_comments', '$doctor_no')");

        if ($insert_lab_result) {
            echo "<script>alert('Lab result added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add lab result.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add More Details</title>
</head>
<body>
    <?php include("../include/header.php"); ?>
    <div class="main1 container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../doctor/doctor-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Add More Details</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <!-- Form for adding more data -->
                                <form method="POST">
                                    <div class="form-group">
                                    <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
                                        <label for="data_type">Choose Detail Type:</label>
                                        <select name="data_type" id="data_type" class="form-control" required>
                                            <option>Choose Detail Type</option>
                                            <option value="medical_record">Medical Record</option>
                                            <option value="prescription">Prescription</option>
                                            <option value="lab_result">Lab Result</option>
                                        </select>
                                    </div>
                                    <br>

                                    <div class="form-group" id="record_type_group" style="display:none;">
                                        <label for="record-type">Record Type (e.g., Consultation, Surgery):</label>
                                        <input type="text" id="record-type" name="record_type" class="form-control" placeholder="e.g., Consultation" />
                                    </div>

                                    <div class="form-group" id="description_group" style="display:none;">
                                        <label for="description">Description:</label>
                                        <textarea id="description" name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group" id="doctor_notes_group" style="display:none;">
                                        <label for="doctor_notes">Doctor Notes:</label>
                                        <textarea id="doctor_notes" name="doctor_notes" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group" id="treatment_plan_group" style="display:none;">
                                        <label for="treatment_plan">Treatment Plan:</label>
                                        <textarea id="treatment_plan" name="treatment_plan" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group" id="height_group" style="display:none;">
                                        <label for="height">Height (cm):</label>
                                        <input type="number" id="height" name="height" class="form-control" step="any" />
                                    </div>

                                    <div class="form-group" id="weight_group" style="display:none;">
                                        <label for="weight">Weight (kg):</label>
                                        <input type="number" id="weight" name="weight" class="form-control" step="any" />
                                    </div>

                                    <div class="form-group" id="medication_group" style="display:none;">
                                        <label for="medication">Medication Name:</label>
                                        <input type="text" id="medication" name="medication" class="form-control" />
                                    </div>

                                    <div class="form-group" id="dosage_group" style="display:none;">
                                        <label for="dosage">Dosage:</label>
                                        <input type="text" id="dosage" name="dosage" class="form-control" />
                                    </div>

                                    <div class="form-group" id="instructions_group" style="display:none;">
                                        <label for="instructions">Instructions:</label>
                                        <textarea id="instructions" name="instructions" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group" id="test_name_group" style="display:none;">
                                        <label for="test_name">Test Name:</label>
                                        <input type="text" id="test_name" name="test_name" class="form-control" />
                                    </div>

                                    <div class="form-group" id="test_result_group" style="display:none;">
                                        <label for="test_result">Test Result:</label>
                                        <input type="text" id="test_result" name="test_result" class="form-control" />
                                    </div>

                                    <div class="form-group" id="doctor_comments_group" style="display:none;">
                                        <label for="doctor_comments">Doctor's Comments:</label>
                                        <textarea id="doctor_comments" name="doctor_comments" class="form-control"></textarea>
                                    </div>
                                    <br><br>
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    <br><br>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                            <br><br>
                            
                            <a href="doctor-view.php?tab_id=<?php echo $tab_id; ?>&id=<?php echo $patient_n; ?>" class="d-grid gap-2 d-md-flex justify-content-center">
    <button class="btn btn-info me-md-2">Back</button>
</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show relevant fields based on selected data type
        document.getElementById('data_type').addEventListener('change', function() {
            var selectedType = this.value;
            document.getElementById('record_type_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';
            document.getElementById('description_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';
            document.getElementById('doctor_notes_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';
            document.getElementById('treatment_plan_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';
            document.getElementById('height_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';
            document.getElementById('weight_group').style.display = selectedType === 'medical_record' ? 'block' : 'none';

            document.getElementById('medication_group').style.display = selectedType === 'prescription' ? 'block' : 'none';
            document.getElementById('dosage_group').style.display = selectedType === 'prescription' ? 'block' : 'none';
            document.getElementById('instructions_group').style.display = selectedType === 'prescription' ? 'block' : 'none';

            document.getElementById('test_name_group').style.display = selectedType === 'lab_result' ? 'block' : 'none';
            document.getElementById('test_result_group').style.display = selectedType === 'lab_result' ? 'block' : 'none';
            document.getElementById('doctor_comments_group').style.display = selectedType === 'lab_result' ? 'block' : 'none';
        });
    </script>
</body>
</html>