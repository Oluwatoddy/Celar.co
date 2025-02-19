<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php'; // Ensures only logged-in admins can access

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['vendor_id'])) {
        echo "Vendor ID missing.";
        exit();
    }
    $vendor_id = $_POST['vendor_id'];
    
    $stmt = $conn->prepare("DELETE FROM vendors WHERE id = ?");
    $stmt->bind_param("i", $vendor_id);
    
    if ($stmt->execute()) {
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        echo "Error deleting vendor: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>