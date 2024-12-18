<?php
session_start();
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $adminId = trim($_POST['adminId']);
    $firstName = trim(htmlspecialchars($_POST['firstName']));
    $lastName = trim(htmlspecialchars($_POST['lastName']));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    try {
        // Validate inputs
        if (empty($adminId) || empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }

        // Validate admin ID format
        if (!preg_match("/^ADMIN-\d{3}$/", $adminId)) {
            throw new Exception("Invalid Admin ID format");
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Validate password length and match
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }

        if ($password !== $confirmPassword) {
            throw new Exception("Passwords do not match");
        }

        // Start transaction
        mysqli_begin_transaction($conn);

        // Check if email already exists
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            throw new Exception("Email already registered");
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into users table
        $stmt = mysqli_prepare($conn, "INSERT INTO users (user_id, email, password, user_type, created_at) VALUES (?, ?, ?, 'admin', NOW())");
        mysqli_stmt_bind_param($stmt, "sss", $adminId, $email, $hashedPassword);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error creating admin account");
        }

        // Insert into admins table
        $stmt = mysqli_prepare($conn, "INSERT INTO admins (admin_id, first_name, last_name) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $adminId, $firstName, $lastName);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error creating admin profile");
        }

        // Commit transaction
        mysqli_commit($conn);

        // Set session variables for logged in user
        $_SESSION['user_id'] = $adminId;
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = 'admin';

        // Redirect to admin dashboard
        header("Location: ../view/admin-dashboard.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../view/school-admin-register.php");
        exit();
    }
} else {
    // If not POST request, redirect to registration page
    header("Location: ../view/school-admin-register.php");
    exit();
}
