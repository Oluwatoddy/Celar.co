<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php'; // Ensures only logged-in admins can access

// Fetch vendors from database
$result = $conn->query("SELECT * FROM vendors ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChopNow - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e9ddcc] min-h-screen flex flex-col items-center">
    <h1 class="text-3xl font-bold mt-6 text-[#c1280f]">Admin Dashboard</h1>
    <a href="../actions/logout.php" class="text-red-600 mt-2">Logout</a>
    <div class="w-4/5 mt-6 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Registered Vendors</h2>
        <a href="../actions/export_vendors.php" class="bg-green-500 text-white px-4 py-2 rounded">Export to CSV</a>
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">ID</th>
                    <th class="border border-gray-300 p-2">Name</th>
                    <th class="border border-gray-300 p-2">Email</th>
                    <th class="border border-gray-300 p-2">Phone</th>
                    <th class="border border-gray-300 p-2">Business</th>
                    <th class="border border-gray-300 p-2">Address</th>
                    <th class="border border-gray-300 p-2">Registered At</th>
                    <th class="border border-gray-300 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td class="border border-gray-300 p-2"><?php echo $row['id']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['name']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['email']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['phone']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['business_name']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['business_address']; ?></td>
                    <td class="border border-gray-300 p-2"><?php echo $row['created_at']; ?></td>
                    <td class="border border-gray-300 p-2">
                    <form action="../actions/update_vendor.php" method="POST" class="inline-block">
                            <input type="hidden" name="vendor_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                        </form>
                        <form action="../actions/delete_vendor.php" method="POST" class="inline-block ml-2">
                            <input type="hidden" name="vendor_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>