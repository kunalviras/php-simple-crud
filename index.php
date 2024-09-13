<?php
include_once "./backend/connection.php";
// Read
$userListing = $conn->query("SELECT * FROM users");

// Check if we're in edit mode
$editMode = false;
$editUser = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id = $editId");
    $editUser = $result->fetch_assoc();
}

// Display success message if set
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<script>alert('$message');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP crud by kunal viras.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-8">
            <h1 class="text-2xl font-bold mb-4">User Management</h1>

            <!-- Create/Edit Form -->
            <form action="/backend/scriptcode.php" method="post" class="mb-4">
                <?php if ($editMode): ?>
                    <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
                <?php endif; ?>
                <input type="text" name="name" placeholder="Name" required class="w-full p-2 mb-2 border rounded" value="<?php echo $editMode ? $editUser['name'] : ''; ?>">
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 mb-2 border rounded" value="<?php echo $editMode ? $editUser['email'] : ''; ?>">
                <button type="submit" name="<?php echo $editMode ? 'update' : 'create'; ?>" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                    <?php echo $editMode ? 'Update User' : 'Create User'; ?>
                </button>
                <?php if ($editMode): ?>
                    <a href="index.php" class="ml-2 text-gray-500 hover:underline">Cancel</a>
                <?php endif; ?>
            </form>

            <!-- User List -->
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $userListing->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                                <a href="/backend/scriptcode.php?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>