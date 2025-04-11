<?php
session_start();

// Get tab ID from URL
$tab_id = $_GET['tab_id'] ?? null;

if ($tab_id && isset($_SESSION['patient'][$tab_id])) {
    unset($_SESSION['patient'][$tab_id]);

    // If no more sessions in this role, clean up
    if (empty($_SESSION['patient'])) {
        unset($_SESSION['patient']);
    }
}

// Optional: Redirect to admin login with success message
header("Location: ../patient-login.php?logout=success");
exit();
?>