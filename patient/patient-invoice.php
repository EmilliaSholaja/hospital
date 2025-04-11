<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

// You can access the logged-in patient ID using:
$patient_id = $_SESSION['patient'][$tab_id];

include("../include/connection.php");



$query = "SELECT * FROM income WHERE patient_id = '$patient_id' ORDER BY date_discharge DESC";
$result = mysqli_query($connect, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connect));
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Invoice</title>
    <style>
        

        .button-container {
            display: flex;
            gap: 10px; /* Adjust space between the buttons */
            justify-content: flex-start; /* Align buttons to the left */
            align-items: center; /* Vertically align buttons in the center */
        }

        .button-container .btn {
            flex-shrink: 0; /* Prevent the button from shrinking */
        }
    </style>
    
</head>
<body>
    <?php 
        include("../include/header.php");
        include("../include/connection.php");
    ?>
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../patient/patient-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                <h5 class="text-center my-2">My Invoices</h5>
    <table class="table table-responsive table-bordered" cellpadding="8">
        <thead>
            <tr>
                <th>#</th>
                <th>Doctor</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date Issued</th>
                <th>Payment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$row['doctor_name']}</td>";
            echo "<td>₦{$row['amount_paid']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['date_discharge']}</td>";
            echo "<td>" . (!empty($row['payment_date']) ? $row['payment_date'] : "<i>Pending</i>") . "</td>";
            echo "<td>";
            echo "<div class='button-container'>";
            echo "<a href='view-invoice.php?tab_id=$tab_id&id={$row['id']}' class='btn btn-primary'>View Details</a> ";
            if ($row['status'] == 'Unpaid') {
                echo "<a href='pay-invoice.php?id={$id}&tab_id={$tab_id}' class='btn btn-success'>Pay Now</a>";
            }
            echo "</div>";
            echo "</td>";

            ;
            

            $i++;
        }
        ?>
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>