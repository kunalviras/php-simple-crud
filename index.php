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
    <title>PHP CRUD by Kunal Viras</title>
    <script src="/tailwind.css"></script>
</head>
<body class="bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-800 text-white">
            <h1 class="text-3xl font-bold">User Management</h1>
            <p class="mt-1 text-sm">Manage your users with this simple CRUD application</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <!-- Create/Edit Form -->
            <form action="/backend/scriptcode.php" method="post" class="mb-8 bg-gray-50 p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4"><?php echo $editMode ? 'Edit User' : 'Create New User'; ?></h2>
                <?php if ($editMode): ?>
                    <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
                <?php endif; ?>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter name" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                           value="<?php echo $editMode ? $editUser['name'] : ''; ?>">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter email" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                           value="<?php echo $editMode ? $editUser['email'] : ''; ?>">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" name="<?php echo $editMode ? 'update' : 'create'; ?>" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <?php echo $editMode ? 'Update User' : 'Create User'; ?>
                    </button>
                    <?php if ($editMode): ?>
                        <a href="index.php" class="text-sm text-indigo-600 hover:text-indigo-900">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- User List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row = $userListing->fetch_assoc()): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $row['name']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['email']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="?edit=<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <a href="/backend/scriptcode.php?delete=<?php echo $row['id']; ?>" 
                                       class="text-red-600 hover:text-red-900" 
                                       onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>