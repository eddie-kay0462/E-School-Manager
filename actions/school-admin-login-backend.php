<?php
session_start();
include '../db/config2.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: ../view/school-admin-login.php");
        exit();
    }

    $query = "SELECT * FROM users WHERE email = ? AND user_type = 'admin' LIMIT 1";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);

        if ($admin && password_verify($password, $admin['password'])) {
            // Login successful
            $_SESSION['user_id'] = $admin['user_id'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['user_type'] = 'admin';

            header("Location: ../view/admin-dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: ../view/school-admin-login.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Database error: " . mysqli_error($conn);
        header("Location: ../view/school-admin-login.php");
        exit();
    }
} else {
    header("Location: ../view/school-admin-login.php");
    exit();
}
