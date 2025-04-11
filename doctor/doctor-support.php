<?php
session_start();
$tab_id = $_GET['tab_id'] ?? '';

if (!isset($_SESSION['doctor'][$tab_id])) {
    header("Location: ../doctor-login.php");
    exit();
}

$doctor_id = $_SESSION['doctor'][$tab_id];
include("../include/connection.php");

$doctor_hospital_id = $doctor_id;

// Fetch support tickets
$query = "
SELECT st.*, d.fullName AS doctor_name, d.email AS doctor_email 
FROM support_tickets st
JOIN doctor d ON st.user_id = d.Doctor_hospital_id
WHERE st.user_id = '$doctor_hospital_id' 
ORDER BY st.created_at DESC
";
$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<script>alert('Error fetching tickets!');</script>";
}

// Handle new ticket submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ticket'])) {
    $subject = mysqli_real_escape_string($connect, $_POST['subject']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    if (!empty($subject) && !empty($message)) {
        $insert_query = "INSERT INTO support_tickets (user_id, user_role, subject, message, status, created_at, fullName, email) 
                         SELECT '$doctor_hospital_id', 'doctor', '$subject', '$message', 'Open', NOW(), fullName, email 
                         FROM doctor WHERE Doctor_hospital_id= '$doctor_hospital_id'";

        if (mysqli_query($connect, $insert_query)) {
            echo "<script>alert('Support ticket submitted successfully!'); window.location.href = '../doctor/doctor-support.php?tab_id={$tab_id}';</script>";
        } else {
            echo "<script>alert('Error submitting ticket!');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}

// Handle response
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_response'])) {
    $ticket_id = $_POST['ticket_id'];
    $response = mysqli_real_escape_string($connect, $_POST['response']);

    if (!empty($response)) {
        $update_query = "UPDATE support_tickets 
                         SET response = '$response', status = 'Closed' 
                         WHERE ticket_id = '$ticket_id' AND user_id = '$doctor_hospital_id'";

        if (mysqli_query($connect, $update_query)) {
            echo "<script>alert('Response sent successfully!'); window.location.href = '../doctor/doctor-support.php?tab_id={$tab_id}';</script>";
        } else {
            echo "<script>alert('Error sending response!');</script>";
        }
    } else {
        echo "<script>alert('Please provide a response.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include("../include/header.php"); ?>
<div class="container-fluid main1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -20px;">
                <?php include("doctor-sidenav.php"); ?>
            </div>
            <div class="col-md-10 main--content">
                <div class="container-fluid">
                    <h5 class="text-center">Support Center</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="main2 p-4 bg-light border rounded">
                                <h4 class="text-center">Submit a Support Ticket</h4>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea name="message" class="form-control" required></textarea>
                                    </div>
                                    <button type="submit" name="submit_ticket" class="btn btn-primary">Submit Ticket</button>
                                </form>
                            </div>
                            <br><br>
                            <a href="faq.php?tab_id=<?php echo $tab_id; ?>">Frequently Asked Questions</a>
                        </div>

                        <div class="col-md-6">
                            <div class="main2 p-4 bg-light border rounded">
                                <h4 class="text-center">Your Previous Support Tickets</h4>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($ticket = mysqli_fetch_assoc($result)): ?>
                                        <div class="bg-white border p-3 my-3">
                                            <h5 class="text-primary"><?= htmlspecialchars($ticket['subject']) ?></h5>
                                            <p><?= nl2br(htmlspecialchars($ticket['message'])) ?></p>
                                            <small class="text-muted">Submitted: <?= $ticket['created_at'] ?></small><br>
                                            <small class="text-muted">By: <?= htmlspecialchars($ticket['fullName']) ?> (<?= htmlspecialchars($ticket['email']) ?>)</small>
                                            
                                            <?php if (!empty($ticket['response'])): ?>
                                                <div class="alert alert-success mt-2">
                                                    <strong>Admin Response:</strong> <?= nl2br(htmlspecialchars($ticket['response'])) ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-warning mt-2"><i>Awaiting response...</i></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p class="text-muted">No support tickets found.</p>
                                <?php endif; ?>
                            </div>
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