<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password_hash FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();
        
        if (password_verify($password, $password_hash)) {
            $_SESSION['admin_id'] = $id;
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No such user found.";
    }
    
    $stmt->close();
    $conn->close();
}
?>