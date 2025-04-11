<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['admin'][$tab_id])) {
    header("Location: ../admin-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$admin_id = $_SESSION['admin'][$tab_id];

include("../include/connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM doctor WHERE DoctorID = '$id'";
    $res = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($res);
}

// Handle form submission before any HTML output
if (isset($_POST['update_salary'])) {
    $salary = $_POST['salary'];
    $q = "UPDATE doctor SET salary ='$salary' WHERE DoctorID='$id'";
    if (mysqli_query($connect, $q)) {
        header("Location: edit.php?id=$id&tab_id=$tab_id"); // Pass tab_id in URL to retain context
        exit(); // Stop execution to ensure proper redirection
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor Details</title>
    <style>
        h6{
            font-size:13px!important;
        }

@media (max-width: 768px) {
    h6 {
        font-size: 12px !important;
    }

    .btn {
        width: 90% !important;
    }
}
    </style>
</head>
<body>
    <?php
        include("../include/header.php");
        include("../include/connection.php");
    ?>

<div class="main1 d-flex">
    <div class="row w-100">
        <div class="col-md-2">
            <?php include("../admin/sidenav.php") ?>
        </div>
        <div class="col-md-10 main--content">
                    <h5 class="text-center">Edit Doctor Details</h5>

                    <?php
                        if (isset($_GET['id'])) {
                           $id = $_GET['id'];

                           $query = "SELECT * FROM doctor WHERE DoctorID = '$id'";
                           $res = mysqli_query($connect, $query);

                           $row = mysqli_fetch_array($res);

                        }
                    ?>
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-center">Doctor Details</h5>
                            <h6 class="my-3">ID: <?php echo $row['DoctorID']; ?></h6>
                            <h6 class="my-3">Doctor Hospital ID: <?php echo $row['Doctor_hospital_id']; ?></h6>
                            <h6 class="my-3">Full Name: <?php echo $row['fullName']; ?></h6>
                            <h6 class="my-3">Email: <?php echo $row['email']; ?></h6>
                            <h6 class="my-3">Gender: <?php echo $row['gender']; ?></h6>
                            <h6 class="my-3">Phone Number: <?php echo $row['phone_number']; ?></h6>
                            <h6 class="my-3">Date Of Birth: <?php echo $row['date_of_birth']; ?></h6>
                            <h6 class="my-3">Country: <?php echo $row['country']; ?></h6>
                            <h6 class="my-3">Specialization: <?php echo $row['specialization']; ?></h6>
                            <h6 class="my-3">Medical Degree: <?php echo $row['medical_degree']; ?></h6>
                            <h6 class="my-3">Year Of Experience: <?php echo $row['Year_of_experience']; ?></h6>
                            <h6 class="my-3">Current Hospital: <?php echo $row['Current_Hospital']; ?></h6>
                            <h6 class="my-3">Medical License Number: <?php echo $row['Medical_License_Number']; ?></h6>
                            <h6 class="my-3">Data Registred: <?php echo $row['data_reg']; ?></h6>
                            <h6 class="my-3">Salary: <?php echo $row['salary']; ?> per year</h6>
                        </div>

                        <div class="col-md-4">
                            <h5 class="text-center">Update Salary</h5>
                            <form action="" method="post">
                                <label for="salary">Enter Doctor's Salary</label>
                                <input type="text" class="form-control" name="salary" autocomplete="off" placeholder="Enter Salary" value="<?php echo $row['salary']; ?>">
                                <input type="hidden" name="tab_id" value="<?php echo $tab_id; ?>"> <!-- Hidden input for tab_id -->
                                <input type="submit" name="update_salary" class="btn btn-info my-3" value="Update Salary">
                            </form>
                        </div>

                        
                        <br><br>
                        <a href="doctor.php?tab_id=<?php echo $tab_id; ?>" class="d-grid gap-2 d-md-flex justify-content-center">
                            <button class="btn btn-info me-md-2">Back</button>
                        </a>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>