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

function fetchTickets($condition, $connect) {
    $query = "
        SELECT st.*, 
            CASE 
                WHEN st.user_role = 'patient' THEN p.fullName 
                WHEN st.user_role = 'doctor' THEN d.fullName 
            END AS user_name,
            CASE 
                WHEN st.user_role = 'patient' THEN p.email 
                WHEN st.user_role = 'doctor' THEN d.email 
            END AS user_email
        FROM support_tickets st
        LEFT JOIN patient p ON st.user_id = p.Patient_No AND st.user_role = 'patient'
        LEFT JOIN doctor d ON st.user_id = d.Doctor_hospital_id AND st.user_role = 'doctor'
        WHERE $condition
        ORDER BY st.created_at DESC
    ";

    return mysqli_query($connect, $query);
}

// Assign results to variables
$result_unresolved = fetchTickets("(st.response IS NULL OR st.response = '')", $connect);
$result_resolved = fetchTickets("(st.response IS NOT NULL AND st.response <> '')", $connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Support Tickets</title>
    <style>
    .table-container {
        max-height: 400px; /* Adjust as needed */
        overflow-y: auto;
    }
    @media (max-width: 922px) {
        .table-container {
            max-height: 300px; /* Adjust as needed */
            overflow-y: auto;
        }
    }
    </style>
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
                    <h5 class="text-center">Support Tickets</h5>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-center">Pending Support Tickets</h5>
                                <div class="table-container">
                                    <table class="table table-responsive table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Role</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Response</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $counter = 1;
                                            while ($row = mysqli_fetch_assoc($result_unresolved)) { ?>
                                                <tr>
                                                    <td><?= $counter++; ?></td>
                                                    <td><?= htmlspecialchars($row['user_role']); ?></td>
                                                    <td><?= htmlspecialchars($row['user_name']); ?></td>
                                                    <td><?= htmlspecialchars($row['user_email']); ?></td>
                                                    <td><?= htmlspecialchars($row['subject']); ?></td>
                                                    <td><?= htmlspecialchars($row['message']); ?></td>
                                                    <td><?= htmlspecialchars($row['status']); ?></td>
                                                    <td><?= !empty($row['response']) ? htmlspecialchars($row['response']) : 'No Response Yet...'; ?></td>
                                                    <td>
                                                        <a href="respond.php?ticket_id=<?= $row['id']; ?>&tab_id=<?= $tab_id; ?>" class="btn btn-primary btn-sm">Respond</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center">Resolved Support Tickets</h5>
                                <div class="table-container">
                                    <table class="table table-responsive table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Role</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Response</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $counter = 1;
                                            while ($row = mysqli_fetch_assoc($result_resolved)) { ?>
                                                <tr>
                                                    <td><?= $counter++; ?></td>
                                                    <td><?= htmlspecialchars($row['user_role']); ?></td>
                                                    <td><?= htmlspecialchars($row['user_name']); ?></td>
                                                    <td><?= htmlspecialchars($row['user_email']); ?></td>
                                                    <td><?= htmlspecialchars($row['subject']); ?></td>
                                                    <td><?= htmlspecialchars($row['message']); ?></td>
                                                    <td><?= htmlspecialchars($row['status']); ?></td>
                                                    <td><?= htmlspecialchars($row['response']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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