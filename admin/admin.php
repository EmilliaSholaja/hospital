<?php
ob_start();
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['admin'][$tab_id])) {
    header("Location: ../admin-login.php");
    exit();
}

$admin_id = $_SESSION['admin'][$tab_id];
?><!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
    <style>
        .bg-lavender {
            background-color: #e6e6fa!important;
            color: #3a278f !important;
        }
        @media screen and (max-width: 768px) {
            table1{
                overflow: scroll!important;
            }
        }
    </style>
</head>
<body>
    <?php include("../include/header.php"); ?><div class="main1 d-flex">
    <div class="row w-100">
        <div class="col-md-2">
            <?php include("../admin/sidenav.php"); include("../include/connection.php"); ?>
        </div>
        <div class="col-md-10 main--content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 ">
                        <h5 class="text-center">All Admin</h5>
                        <?php 
                            $ad = $_SESSION['admin'][$tab_id];
                            $query = "SELECT * FROM admin WHERE admin_hospital_id !='$ad'";
                            $res = mysqli_query($connect, $query);

                            $output = "
                            <table class='table table-responsive table1 table-bordered'>
                                <thead>
                                    <th>ID</th>
                                    <th>Admin-Number</th>
                                    <th>Name</th>
                                    <th style='width:10%;'>Action</th>
                                </thead>
                            ";

                            if (mysqli_num_rows($res) < 1) {
                                $output .= "<tr><td colspan='4' class='text-center'>No New Admin</td></tr>";
                            }

                            while($row = mysqli_fetch_array($res)){
                                $id = $row['Admin_ID'];
                                $admin_hospital_id = $row['admin_hospital_id'];
                                $name = $row['admin_name'];

                                $output .= "
                                    <tbody>
                                        <tr>
                                            <td>$id</td>
                                            <td>$admin_hospital_id</td>
                                            <td>$name</td>
                                            <td>
                                                <a href='admin.php?Admin_ID=$id&tab_id=$tab_id'><button class='btn btn-danger' id='$id'>Remove</button></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                ";
                            }

                            $output .= "</table>";
                            echo $output;

                            if (isset($_GET['Admin_ID'])) {
                                $id = $_GET['Admin_ID'];
                                $query = "SELECT profile FROM admin WHERE Admin_ID = '$id'";
                                $result = mysqli_query($connect, $query);
                                $row = mysqli_fetch_assoc($result);

                                if ($row) {
                                    $imagePath = "../admin/img/" . $row['profile'];
                                    if (file_exists($imagePath) && !empty($row['profile'])) {
                                        unlink($imagePath);
                                    }

                                    $query = "DELETE FROM admin WHERE Admin_ID = '$id'";
                                    mysqli_query($connect, $query);

                                    mysqli_query($connect, "SET @num := 0");
                                    mysqli_query($connect, "UPDATE admin SET Admin_ID = @num := @num + 1 ORDER BY Admin_ID");
                                    mysqli_query($connect, "ALTER TABLE admin AUTO_INCREMENT = 1");

                                    header("Location: admin.php?tab_id=$tab_id");
                                    exit();
                                }
                            }
                        ?>
                    </div>

                    <div class="col-md-6">
                        <?php 
                            if (isset($_POST['add'])) {
                                $hospital_ID = $_POST['hospital_ID'];
                                $pass = $_POST['password'];
                                $admin_name = $_POST['admin_name'];
                                $image = $_FILES['img']['name'];

                                $error = array();
                                if (empty($hospital_ID)) {
                                    $error['u'] = "Enter Admin Hospital ID";
                                } elseif (empty($pass)) {
                                    $error['u'] = "Enter Admin Password";
                                } elseif (empty($admin_name)) {
                                    $error['u'] = "Enter Admin Name";
                                } elseif (empty($image)) {
                                    $error['u'] = "Add Admin Picture";
                                }

                                if (count($error) == 0) {
                                    $q = "INSERT INTO admin(admin_hospital_id, password, profile, admin_name) VALUES('$hospital_ID', '$pass', '$image', '$admin_name')";
                                    $result = mysqli_query($connect, $q);

                                    if ($result) {
                                        move_uploaded_file($_FILES['img']['tmp_name'], "../admin/img/$image");
                                        header("Location: admin.php?tab_id=$tab_id");
                                        exit();
                                    }
                                }
                            }

                            $show = isset($error['u']) ? "<h5 class='text-center alert alert-danger'>{$error['u']}</h5>" : "";
                        ?>

                        <h5 class="text-center">Add Admin</h5>
                        <form action="admin.php?tab_id=<?= urlencode($tab_id); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="tab_id" value="<?= htmlspecialchars($tab_id); ?>">
                            <div><?php echo $show; ?></div>
                            <div class="from-group">
                                <label for="hospital_ID">Admin Hospital ID</label>
                                <input type="text" name="hospital_ID" class="form-control" autocomplete="off">
                            </div>
                            <div class="from-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" autocomplete="off">
                            </div>
                            <div class="from-group">
                                <label for="admin_name">Name</label>
                                <input type="text" name="admin_name" class="form-control" autocomplete="off">
                            </div>
                            <div class="from-group">
                                <label for="img">Add Admin Picture</label>
                                <input type="file" name="img" class="form-control">
                            </div><br>
                            <input type="submit" name="add" value="Add New Admin" class="btn btn-success">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php ob_end_flush(); ?>
</html>