<?php
    session_start();
    if (!isset($_SESSION['hospital_number']) || !isset($_SESSION['password'])) {
        echo "<script>alert('Failed to Get Hospital Number && Password');</script>";
        header("Location: ../hospital/patient-register.php");

        exit();
    }

    $hospital_number = $_SESSION['hospital_number'];
    $password = $_SESSION['password'];

    // Clear session data after displaying the message
    unset($_SESSION['hospital_number']);
    unset($_SESSION['password']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/login.css?v=<?php echo time(); ?>">
    <title>Registration Successful</title>

    <style>
    
        .success-container {
            background: lavender;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .success-container h2 {
            color: #9370db;
        }
        .success-container p {
            font-size: 18px;
        }
        .login-link {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            background: #4e34b6!important;
            color: #fff !important;
            border: none;
        }
    </style>


</head>
<body>
   

    <div class="container d-flex justify-content-center align-items-center login-container">
        <div class="row shadow-lg p-4 rounded bg-white w-100" style="max-width: 750px;">
            <!-- Image Section -->
            <div class="col-md-5 d-flex justify-content-center align-items-center">
                <img src="./images/undefined_image.png" alt="Login Image" class="img-fluid login-img">
            </div>

            <!-- Login Form -->
            <div class="col-md-7">
            <div class="success-container">
                <h2>Registration Successful!</h2>
                <p>Your Hospital Number: <strong><?php echo $hospital_number; ?></strong></p>
                <p>Your Password: <strong><?php echo $password; ?></strong></p>
                <a class="login-link" href="../hospital/patient-login.php">Login</a>
            </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>