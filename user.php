<?php
include_once 'dbConnection.php';
session_start();

// Check if the user is logged in
if (!(isset($_SESSION['email']))) {
    header("location:index.php");
    exit();
} else {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    echo '<div class="text-right p-4"><span class="text-green-700 font-semibold">Hello, <a href="#" class="underline">' . htmlspecialchars($name) . '</a></span> | <a href="logout.php?q=account.php" class="text-green-700 underline">Logout</a></div>';
}

// Check if an enable/disable action is triggered
if (isset($_GET['action']) && isset($_GET['user_email'])) {
    $userEmail = $_GET['user_email'];
    $action = $_GET['action'];
    $status = ($action === 'enable') ? 1 : 0;

    $updateSql = "UPDATE user SET status = $status WHERE email = '$userEmail'";
    if ($con->query($updateSql) === TRUE) {
        $actionMessage = "User status updated successfully!";
    } else {
        $actionMessage = "Failed to update user status: " . $con->error;
    }
}

// Fetch and group data from the warning table
$query = "SELECT u.email, COUNT(w.email) AS warning_count, u.status 
          FROM warning w 
          RIGHT JOIN user u ON w.email = u.email 
          GROUP BY u.email, u.status 
          ORDER BY warning_count DESC";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warnings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-green-900">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-4">
            <button onclick="history.back()" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">Back</button>
        </div>
        <h1 class="text-3xl font-bold mb-6 text-green-700">Warning Records</h1>
        <?php if (isset($actionMessage)): ?>
            <p class="text-lg text-green-700 mb-4"><?= htmlspecialchars($actionMessage) ?></p>
        <?php endif; ?>
        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white rounded shadow">
                    <thead class="bg-green-700 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Warnings</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($row['warning_count']) ?></td>
                                <td class="px-4 py-2"><?= $row['status'] == 1 ? 'Enabled' : 'Disabled' ?></td>
                                <td class="px-4 py-2">
                                    <?php if ($row['status'] == 1): ?>
                                        <a href="?action=disable&user_email=<?= urlencode($row['email']) ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Disable</a>
                                    <?php else: ?>
                                        <a href="?action=enable&user_email=<?= urlencode($row['email']) ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enable</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-lg text-green-700">No warnings found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>