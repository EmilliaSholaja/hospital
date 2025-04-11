<?php
session_start();

if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['info'])) {
    echo "<script>alert('" . $_SESSION['info'] . "');</script>";
    unset($_SESSION['info']);
}

$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

// You can access the logged-in admin ID using:
$patient_id = $_SESSION['patient'][$tab_id];

include("../include/connection.php");

if (!isset($_GET['id'])) {
    echo "<script>alert('No invoice ID provided.'); window.location.href = 'patient-invoice.php?tab_id=$tab_id';</script>";
    exit();
}

$invoice_id = $_GET['id'];
$query = "SELECT * FROM income WHERE id = '$invoice_id'";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Invoice not found.'); window.location.href = 'patient-invoice.php?tab_id=$tab_id';</script>";
    exit();
}

$invoice = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice</title>
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
                    <h5 class="text-center my-2">View Invoice Details</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Patient:</strong> <?= $invoice['patient_name'] ?> (<?= $invoice['patient_id'] ?>)</p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Doctor:</strong> <?= $invoice['doctor_name'] ?></p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Description:</strong> <?= $invoice['description'] ?></p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Amount:</strong> ₦<?= $invoice['amount_paid'] ?></p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Status:</strong> <span style="color: <?= ($invoice['status'] == 'Unpaid') ? 'red' : 'green' ?>;"><?= $invoice['status'] ?></span></p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Issued On:</strong> <?= date('F j, Y', strtotime($invoice['date_discharge'])) ?></p>
                                <p style="font-size: 18px; font-weight: bold; color: #333;"><strong>Paid On:</strong> <?= !empty($invoice['payment_date']) ? date('F j, Y', strtotime($invoice['payment_date'])) : "<i>Pending</i>" ?></p>

                                <?php if ($invoice['status'] == 'Unpaid'): ?>
                                    <a class="btn btn-primary" href="pay-invoice.php?id=<?= $invoice['id'] ?>&tab_id=<?= $tab_id ?>">Pay Now</a>
                                <?php endif; ?>
                                <br><br>
                                <a class="btn btn-success" href="patient-invoice.php?tab_id=<?= $tab_id ?>">Back to Invoice List</a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>