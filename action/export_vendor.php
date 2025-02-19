<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php'; // Ensures only logged-in admins can access

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vendors.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Name', 'Email', 'Phone', 'Business Name', 'Business Address', 'Registered At'));

$result = $conn->query("SELECT * FROM vendors ORDER BY created_at DESC");

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

fclose($output);
exit();
?>