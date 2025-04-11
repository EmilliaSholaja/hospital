<?php
session_start();
include("../hospital/include/connection.php");

if (isset($_POST['create'])) {
    // Section 1: Personal Information
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Section 2: Medical Information
    $insurance_provider = $_POST['insurance-provider'];
    $other_insurance = isset($_POST['other-insurance']) ? $_POST['other-insurance'] : "";
    $full_insurance = ($insurance_provider === "Other") ? $other_insurance : $insurance_provider;

    $medical_history = $_POST['medical-history'];
    $current_medications = $_POST['current-medications'];

    $allergies = isset($_POST['allergies']) ? implode(", ", $_POST['allergies']) : "";
    $other_allergy = isset($_POST['other-allergy']) ? $_POST['other-allergy'] : "";
    $full_allergies = trim($allergies . ", " . $other_allergy, ", "); // Combine allergies and other

    $emergency_contact_name = $_POST['emergency-contact-name'];
    $emergency_contact_relationship = $_POST['emergency-contact-relationship'];
    $emergency_contact_phone = $_POST['emergency-contact-phone'];

    $errors_personal = array();  
    $errors_extra = array();  

    // Section 1 Validation
    if (empty($name)) {
        $errors_personal['register'] = "Name is required.";
    }
    if (empty($email)) {
        $errors_personal['register'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors_personal['register'] = "Invalid email format.";
    }
    if (empty($gender)) {
        $errors_personal['register'] = "Gender is required.";
    }
    if (empty($phone)) {
        $errors_personal['register'] = "Phone number is required.";
    } elseif (!preg_match("/^(\+?\d{1,4})?[-.\s]?\d{7,14}$/", $phone)) {
        $errors_personal['register'] = "Enter a valid phone number with country code.";
    }
    if (empty($dob)) {
        $errors_personal['register'] = "Date of birth is required.";
    }
    if (empty($country)) {
        $errors_personal['register'] = "Country is required.";
    }
    if (empty($address)) {
        $errors_personal['register'] = "Address is required.";
    }

    // Section 2 Validation
    if (empty($full_insurance)) {
        $errors_extra['register'] = "Insurance provider is required.";
    }
    if (empty($medical_history)) {
        $errors_extra['register'] = "Medical history is required.";
    }
    if (empty($current_medications)) {
        $errors_extra['register'] = "Current medications field is required.";
    }
    if (empty($full_allergies)) {
        $errors_extra['register'] = "At least one allergy must be specified.";
    }
    if (empty($emergency_contact_name)) {
        $errors_extra['register'] = "Emergency contact name is required.";
    }
    if (empty($emergency_contact_relationship)) {
        $errors_extra['register'] = "Emergency contact relationship is required.";
    }
    if (empty($emergency_contact_phone) || !preg_match("/^(\+?\d{1,4})?[-.\s]?\d{7,14}$/", $emergency_contact_phone)) {
        $errors_extra['register'] = "Valid emergency contact phone number is required.";
    }

    // If no errors, insert into the database and generate hospital number and password
    if (count($errors_personal) == 0 && count($errors_extra) == 0) {
        // Generate hospital number in format: 25/##### (Year/Random 5-digit number)
        $year = date("y");  // Get last two digits of the current year
        $random_number = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT); // 5-digit random number
        $hospital_number = "$year/$random_number";

        // Generate password with format ##@##@@@
        $password = sprintf(
            "%02d%s%02d%s%s",
            rand(10, 99), // Two digits
            chr(rand(65, 90)), // One capital letter
            rand(10, 99), // Two more digits
            chr(rand(65, 90)), // One more capital letter
            chr(rand(65, 90)) . chr(rand(65, 90)) // Two capital letters
        );

        // Insert into database
        $query = "INSERT INTO patient (fullName, email, gender, phone_number, DOB, country, address, Insurance_Provider, Medical_History, Current_Medications, Allergies, E_Contact_Name, E_Contact_relationship, E_Contact_phone, data_reg, Patient_No, password) 
                  VALUES ('$name', '$email', '$gender', '$phone', '$dob', '$country', '$address', '$full_insurance', '$medical_history', '$current_medications', '$full_allergies', '$emergency_contact_name', '$emergency_contact_relationship', '$emergency_contact_phone', NOW(), '$hospital_number', '$password')";

        $result = mysqli_query($connect, $query);

        if ($result) {
            // Reset patient_id sequentially after a deletion
            mysqli_query($connect, "SET @count = 0;");
            mysqli_query($connect, "UPDATE patient SET PatientID = @count := @count + 1;");
            mysqli_query($connect, "ALTER TABLE patient MODIFY COLUMN PatientID INT AUTO_INCREMENT;");

            // Store credentials in session and redirect
            $_SESSION['hospital_number'] = $hospital_number;
            $_SESSION['password'] = $password;
            header("Location: ../hospital/success-message.php");
            exit();
        } else {
            echo "<script>alert('Failed to Submit Registration');</script>";
        }
    }
}
?>