<?php

session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$patient_id = $_SESSION['patient'][$tab_id];


include("../include/connection.php");



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
    $delete_query = "DELETE FROM patient WHERE Patient_No = '$patient_id'";
    
    if (mysqli_query($connect, $delete_query)) {
        // Destroy session and log out user
        $_SESSION = array();
        session_destroy();
        echo "Your account has been deleted successfully.";
    } else {
        echo "Error: Unable to delete your account.";
    }
}
?>