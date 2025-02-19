<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php'; // Ensures only logged-in admins can access

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET['vendor_id'])) {
        echo "No vendor specified.";
        exit;
    }
    $vendor_id = $_GET['vendor_id'];
    $stmt = $conn->prepare("SELECT * FROM vendors WHERE id = ?");
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
         echo "Vendor not found.";
         exit;
    }
    $vendor = $result->fetch_assoc();
    $stmt->close();
    // Display the update form with vendor details pre-populated.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vendor - ChopNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e9ddcc] flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-[#c1280f]">Update Vendor</h2>
        <form action="update_vendor.php" method="POST" class="mt-4">
            <input type="hidden" name="vendor_id" value="<?php echo $vendor['id']; ?>">
            <input type="text" name="name" placeholder="Full Name" class="w-full p-2 border rounded mb-2" value="<?php echo htmlspecialchars($vendor['name']); ?>" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded mb-2" value="<?php echo htmlspecialchars($vendor['email']); ?>" required>
            <input type="text" name="phone" placeholder="Phone Number" class="w-full p-2 border rounded mb-2" value="<?php echo htmlspecialchars($vendor['phone']); ?>" required>
            <input type="text" name="business_name" placeholder="Business Name" class="w-full p-2 border rounded mb-2" value="<?php echo htmlspecialchars($vendor['business_name']); ?>" required>
            <textarea name="business_address" placeholder="Business Address" class="w-full p-2 border rounded mb-2" required><?php echo htmlspecialchars($vendor['business_address']); ?></textarea>
            <button type="submit" class="w-full bg-[#c1280f] text-white py-2 rounded">Update</button>
        </form>
    </div>
</body>
</html>
<?php
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process update request
    if (!isset($_POST['vendor_id'])) {
        echo "Vendor ID missing.";
        exit;
    }
    $vendor_id = $_POST['vendor_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $business_name = $_POST['business_name'];
    $business_address = $_POST['business_address'];

    $stmt = $conn->prepare("UPDATE vendors SET name = ?, email = ?, phone = ?, business_name = ?, business_address = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $business_name, $business_address, $vendor_id);

    if ($stmt->execute()) {
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        echo "Error updating vendor: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>