<?php
    session_start();
    include("../hospital/include/connection.php");
    if(isset($_POST['apply'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $country = $_POST['country'];
        $specialization = $_POST['specialization'];
        $degree = $_POST['degree'];
        $experience = $_POST['experience'];
        $hospital = $_POST['hospital'];
        $license_no = $_POST['license_no'];
    

        $errors_personal = array();  // Errors for section 1 (Personal Information)
        $errors_professional = array();  // Errors for section 2 (Professional Information)



    // 🔹 Section 1: Personal Information Validation
    if (empty($name)) {
        $errors_personal['apply'] = "Name is required.";
    }
    if (empty($email)) {
        $errors_personal['apply'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors_personal['apply'] = "Invalid email format.";
    }
    if (empty($gender)) {
        $errors_personal['apply'] = "Gender is required.";
    }
    if (empty($phone)) {
        $errors_personal['apply'] = "Phone number is required.";
    } elseif (!preg_match("/^(\+?\d{1,4})?[-.\s]?\d{7,14}$/", $phone)) {
        $errors_personal['apply'] = "Enter a valid phone number with country code. Example: +1 234567890.";
    }
   if (empty($dob)) {
        $errors_personal['apply'] = "Date of birth is required.";
    }
    if (empty($country)) {
        $errors_personal['apply'] = "Country is required.";
    }

    // 🔹 Section 2: Professional Information Validation
    if (empty($specialization)) {
        $errors_professional['apply'] = "Specialization is required.";
    }
    if (empty($degree)) {
        $errors_professional['apply'] = "Degree is required.";
    }
    if (empty($experience)) {
        $errors_professional['apply'] = "Experience is required.";
    }
    if (empty($hospital)) {
        $errors_professional['apply'] = "Hospital name is required.";
    }
    if (empty($license_no)) {
        $errors_professional['apply'] = "License number is required.";
    }

    if(count($errors_personal) == 0 && count($errors_professional) == 0){
        $query = "INSERT INTO doctor(fullName, email, gender, phone_Number, date_of_birth, country, specialization, medical_degree, Year_of_experience, Current_Hospital, Medical_License_Number, salary, status, data_reg) 
        VALUES('$name', '$email', '$gender', '$phone', '$dob', '$country', '$specialization', '$degree', $experience, '$hospital', '$license_no', '0', 'PENDING', NOW() )
        ";

        $result = mysqli_query($connect, $query);

        if ($result) {
            echo"<script>alert('You have Successfully Applied')</script>";
            header("Location: ../hospital/doctor-login.php");
        }else{
            echo"<script>alert('Failed to Apply')</script>";
        }
    }


}

?>