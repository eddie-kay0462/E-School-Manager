<?php
session_start();
include '../db/config2.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $parent_id = $_POST['parent_id'];
    $parent_name = $_POST['parentName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ward_id = $_POST['wardId'];

    try {
        $pdo->beginTransaction();

        // Check if ward exists
        $stmt = $pdo->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $stmt->execute([$ward_id]);

        if ($stmt->rowCount() == 0) {
            $_SESSION['error'] = "Ward ID does not exist. Please enter a valid student ID.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Check if parent ID already exists
        $stmt = $pdo->prepare("SELECT parent_id FROM parents WHERE parent_id = ?");
        $stmt->execute([$parent_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Parent ID already exists. Please enter a unique ID.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into users table
        $stmt = $pdo->prepare("INSERT INTO users (user_id, email, password, usertype, created_at) VALUES (?, ?, ?, 'parent', NOW())");
        $stmt->execute([$parent_id, $email, $hashed_password]);

        // Insert into parents table
        $stmt = $pdo->prepare("INSERT INTO parents (parent_id, user_id, fullname, ward_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$parent_id, $parent_id, $parent_name, $ward_id]);

        $pdo->commit();

        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: ../view/parent-login.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Registration failed: " . $e->getMessage();
        header("Location: ../view/parent-registration.php");
        exit();
    }
} else {
    header("Location: ../view/parent-registration.php");
    exit();
}
