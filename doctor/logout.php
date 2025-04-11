<?php
session_start();

// Get tab ID from URL
$tab_id = $_GET['tab_id'] ?? null;

if ($tab_id && isset($_SESSION['doctor'][$tab_id])) {
    unset($_SESSION['doctor'][$tab_id]);

    // If no more sessions in this role, clean up
    if (empty($_SESSION['doctor'])) {
        unset($_SESSION['doctor']);
    }
}

// Optional: Redirect to admin login with success message
header("Location: ../doctor-login.php?logout=success");
exit();
?>