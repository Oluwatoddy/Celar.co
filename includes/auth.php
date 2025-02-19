<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../public/login.html");
    exit();
}
?>