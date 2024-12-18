<?php
include '../db/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_POST['parentName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['wardId']) && isset($_POST['parent_id'])) {
    // Sanitize inputs
    $parentName = htmlspecialchars($_POST['parentName'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $wardId = htmlspecialchars($_POST['wardId'], ENT_QUOTES, 'UTF-8');
    $parentId = htmlspecialchars($_POST['parent_id'], ENT_QUOTES, 'UTF-8');

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: ../view/parent-registration.php");
        exit();
    }

    // Validate parent ID format
    if (!preg_match("/^PRNT-\d{3}$/i", $parentId)) {
        $_SESSION['error'] = "Invalid parent ID format";
        header("Location: ../view/parent-registration.php");
        exit();
    }

    // Validate ward ID format
    if (!preg_match("/^STU-\d{3}$/i", $wardId)) {
        $_SESSION['error'] = "Invalid ward ID format";
        header("Location: ../view/parent-registration.php");
        exit();
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if email already exists
        $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $emailResult = $checkEmailStmt->get_result();

        if ($emailResult->num_rows > 0) {
            $_SESSION['error'] = "Email address " . htmlspecialchars($email) . " is already registered. Please use a different email.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Check if parent ID already exists
        $checkParentIdStmt = $conn->prepare("SELECT parent_id FROM parents WHERE parent_id = ?");
        $checkParentIdStmt->bind_param("s", $parentId);
        $checkParentIdStmt->execute();
        $parentIdResult = $checkParentIdStmt->get_result();

        if ($parentIdResult->num_rows > 0) {
            $_SESSION['error'] = "Parent ID " . htmlspecialchars($parentId) . " is already taken. Please use a different ID.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Check if ward ID exists in students table
        $checkWardStmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $checkWardStmt->bind_param("s", $wardId);
        $checkWardStmt->execute();
        $wardResult = $checkWardStmt->get_result();

        if ($wardResult->num_rows == 0) {
            $_SESSION['error'] = "Student ID " . htmlspecialchars($wardId) . " not found. Please verify the ID.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Check if ward ID already has a parent assigned
        $checkWardParentStmt = $conn->prepare("SELECT p.full_name FROM parents p WHERE p.ward_id = ?");
        $checkWardParentStmt->bind_param("s", $wardId);
        $checkWardParentStmt->execute();
        $wardParentResult = $checkWardParentStmt->get_result();

        if ($wardParentResult->num_rows > 0) {
            $parentInfo = $wardParentResult->fetch_assoc();
            $_SESSION['error'] = "Student ID " . htmlspecialchars($wardId) . " already has a parent (" . htmlspecialchars($parentInfo['full_name']) . ") assigned.";
            header("Location: ../view/parent-registration.php");
            exit();
        }

        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (user_id, email, password, user_type, created_at) VALUES (?, ?, ?, 'parent', NOW())");
        $stmt->bind_param("sss", $parentId, $email, $password);
        $stmt->execute();

        // Insert into parents table
        $stmt = $conn->prepare("INSERT INTO parents (parent_id, user_id, full_name, ward_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $parentId, $parentId, $parentName, $wardId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "Parent registered successfully!";
        header("Location: ../view/parent-registration.php");
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error'] = "Registration failed: " . htmlspecialchars($e->getMessage());
        header("Location: ../view/parent-registration.php");
    }
} else {
    $_SESSION['error'] = "Please fill in all required fields.";
    header("Location: ../view/parent-registration.php");
}
exit();
