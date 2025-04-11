<?php
include("../include/connection.php");
session_start(); // Ensure session is started

// Ensure admin is logged in
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Unauthorized access!'); window.location.href = '../landing.php';</script>";
    exit;
}

// Get ticket ID and tab ID from URL
$ticket_id = isset($_GET['ticket_id']) ? $_GET['ticket_id'] : null;
$tab_id = isset($_GET['tab_id']) ? $_GET['tab_id'] : null;

if (!$ticket_id) {
    echo "<script>alert('Ticket ID missing!'); window.location.href = 'admin-support.php';</script>";
    exit;
}

// Fetch ticket details
$query = "SELECT * FROM support_tickets WHERE id = '$ticket_id'";
$result = mysqli_query($connect, $query);
$ticket = mysqli_fetch_assoc($result);

if (!$ticket) {
    echo "<script>alert('Ticket not found!'); window.location.href = 'admin-support.php';</script>";
    exit;
}

// Handle admin response submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_response'])) {
    $response = mysqli_real_escape_string($connect, $_POST['response']);

    if (!empty($response)) {
        $update_query = "UPDATE support_tickets SET response = '$response', status = 'Resolved' WHERE id = '$ticket_id'";
        mysqli_query($connect, $update_query);
        echo "<script>alert('Response sent successfully!'); window.location.href = 'admin-support.php?tab_id=" . urlencode($tab_id) . "';</script>";
        exit;
    } else {
        echo "<script>alert('Response cannot be empty.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respond to Ticket</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<?php include("../include/header.php"); ?>
<div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("../admin/sidenav.php"); ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    <h5 class="text-center">Support Center</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Respond to Ticket</h2>
                            <p><strong>Subject:</strong> <?= htmlspecialchars($ticket['subject']); ?></p>
                            <p><strong>Message:</strong> <?= htmlspecialchars($ticket['message']); ?></p>

                            <form method="POST">
                                <div class="form-group">
                                    <label for="response">Your Response</label>
                                    <textarea name="response" id="response" class="form-control" rows="4" required></textarea>
                                </div>
                                <button type="submit" name="submit_response" class="btn btn-success mt-2">Send Response</button>
                                <a href="admin-support.php?tab_id=<?= urlencode($tab_id); ?>" class="btn btn-secondary mt-2">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>