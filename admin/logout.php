<?php
session_start();

// Get tab ID from URL
$tab_id = $_GET['tab_id'] ?? null;

if ($tab_id && isset($_SESSION['admin'][$tab_id])) {
    unset($_SESSION['admin'][$tab_id]);

    // If no more sessions in this role, clean up
    if (empty($_SESSION['admin'])) {
        unset($_SESSION['admin']);
    }
}

// Optional: Redirect to admin login with success message
header("Location: ../admin-login.php?logout=success");
exit();
?>