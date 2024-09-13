<?php
include_once "connection.php";

// Function to safely redirect
function redirect($message = '') {
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $url = $baseUrl . dirname($_SERVER['PHP_SELF']) . "/../index.php";
    if ($message) {
        $url .= "?message=" . urlencode($message);
    }
    header("Location: $url");
    exit();
}

// Create
if (isset($_POST['create'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        redirect("User created successfully");
    } else {
        redirect("Error: " . $conn->error);
    }
}

// Update
if (isset($_POST['update'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        redirect("User updated successfully");
    } else {
        redirect("Error: " . $conn->error);
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        redirect("User deleted successfully");
    } else {
        redirect("Error: " . $conn->error);
    }
}

$conn->close();