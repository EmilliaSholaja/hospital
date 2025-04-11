<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';  // Get the tab_id from the query parameters

// Check if patient session exists for the given tab_id
if (!isset($_SESSION['patient'][$tab_id])) {
    header("Location: ../patient-login.php");
    exit();
}

$patient_id = $_SESSION['patient'][$tab_id];
include("../include/connection.php");



$invoice_id = $_GET['id'];  // Use invoice_id from the URL

// Check if the invoice has already been paid
$check_query = mysqli_query($connect, "SELECT status, amount_paid FROM income WHERE id = '$invoice_id'");
$check = mysqli_fetch_assoc($check_query);

if ($check['status'] == 'Paid') {
    $_SESSION['info'] = "Invoice already paid.";
    header("Location: ../patient/view-invoice.php?tab_id=" . $tab_id);
    exit();
}

// Handle the form submission to process the payment
if (isset($_POST['pay'])) {
    $payment_method = $_POST['payment_method'];

    $insert = mysqli_query($connect, "SELECT * FROM income WHERE id = '$invoice_id'");
    $row = mysqli_fetch_assoc($insert);

    $update = mysqli_query($connect, "UPDATE income SET status = 'Paid', payment_date = NOW() WHERE id = '$invoice_id'");

    if ($update) {
        $_SESSION['success'] = "Payment successful!";
    } else {
        $_SESSION['error'] = "Payment failed.";
    }

    header("Location: ../patient/view-invoice.php?tab_id=" . $tab_id."&id=".$row['id']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Invoice</title>
</head>
<body>
    <?php 
        include("../include/header.php");
    ?>
    <div class="container-fluid main1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -20px;">
                    <?php include("../patient/patient-sidenav.php") ?>
                </div>
                <div class="col-md-10 main--content">
                    <h5 class="text-center my-2">Pay Invoice</h5>
                    <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-3"></div>
                    <div class="col-md-6">
                         <!-- Add interactive payment form here -->
                        <div class="payment-section">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="payment-method">Payment Method:</label>
                                    <select id="payment-method" name="payment_method" class="form-control">
                                        <option value="credit_card">Credit Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="mobile_payment">Mobile Payment</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="amount">Amount:</label>
                                    <input type="text" id="amount" name="amount" class="form-control" value="<?= $check['amount_paid'] ?? 0 ?>" readonly>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" name="pay" class="btn btn-primary">Pay Now</button>
                                </div>
                                <br><br>
                            </form>
                        </div>

                        <br><br>
                        <a href="patient-invoice.php?tab_id=<?= $tab_id ?>" class="btn btn-secondary">Back to Invoices</a>
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