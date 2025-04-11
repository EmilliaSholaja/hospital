<?php
session_start();
include("./include/connection.php");

if (isset($_POST['login'])) {
    $patient_hospital_id = trim($_POST['patient_hospital_id']);
    $pass = trim($_POST['pass']);
    $tab_id = trim($_POST['tab_session_id']); // This comes from JavaScript

    $error = array();
    if (empty($patient_id)) {
        $error['patient'] = "Enter Doctor Hospital Identification Number";
    } elseif (empty($pass)) {
        $error['patient'] = "Enter Password";
    }

    if (!empty($patient_hospital_id) && !empty($pass) && !empty($tab_id)) {
        $query = "SELECT * FROM patient WHERE Patient_No = '$patient_hospital_id' AND password = '$pass'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 1) {
            // Store login state for this specific tab
            $_SESSION['patient'][$tab_id] = $patient_hospital_id;
            // Pass the tab ID to the dashboard
            header("Location: ./patient/patient-index.php?tab_id=$tab_id");
            exit();
        } else {
            echo "<script>alert('Invalid ID or Password');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/login.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include("./include/header.php"); ?>

    <div class="container d-flex justify-content-center align-items-center login-container">
        <div class="row shadow-lg p-4 rounded bg-white w-100" style="max-width: 750px;">
            <!-- Image Section -->
            <div class="col-md-5 d-flex justify-content-center align-items-center">
                <img src="./images/undefined_image.png" alt="Login Image" class="img-fluid login-img">
            </div>

            <!-- Login Form -->
            <div class="col-md-7">
                <h3 class="text-center">Patient Login</h3>
                <p class="text-muted text-center">Sign Into Your Account</p>
                <div class="alert alert-danger"  style="display: <?php echo isset($error['patient']) ? 'block' : 'none'; ?>;">
                    <?php 
                    if(isset($error['patient'])){
                        $show = $error['patient'];
                    }else{
                        $show = "";
                    }
                    echo $show;
                    ?>
                    </div>
                <form method="post">
                    <div class="mb-3">
                        <input type="text" name="patient_hospital_id" class="form-control" placeholder="Patient's Hospital Number" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="tab_session_id" id="tab_session_id" class="form-control" placeholder="Admin's Hospital Identification Number" autocomplete="off">
                    </div>               
                    <div class="mb-3">
                        <input type="password" name="pass" class="form-control" placeholder="User Password" autocomplete="off">
                    </div>
                    
                    <button class="btn  w-100" name="login" type="submit">Login</button>
                </form>

                <p class="info mt-3 text-center">
                    Don't Have An Account? <a href="../hospital/patient-register.php" class="account">Register Here</a>
                </p>
            </div>
        </div>
    </div>

    <script>
    // Generate a unique tab ID if not already set
    if (!sessionStorage.getItem('tab_session_id')) {
        sessionStorage.setItem('tab_session_id', 'tab_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9));
    }

    document.getElementById('tab_session_id').value = sessionStorage.getItem('tab_session_id');
</script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>