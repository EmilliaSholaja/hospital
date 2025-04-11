<?php



    include("../include/connection.php");

    $id = $_POST['id'];
    $DoctorHosID = $_POST['username'];
    $password = $_POST['password']; // Secure password

    // Update doctor status and add login credentials
    $query = "UPDATE doctor SET status='APPROVED', Doctor_hospital_id='$DoctorHosID', password='$password' WHERE DoctorID = '$id'";
    mysqli_query($connect, $query);

    // Reset IDs sequentially
    $query1 = "SET @count = 0";
    mysqli_query($connect, $query1);

    $query2 = "UPDATE doctor SET DoctorID = (@count:=@count + 1)";
    mysqli_query($connect, $query2);

    echo "Doctor approved and login credentials set!";
?>