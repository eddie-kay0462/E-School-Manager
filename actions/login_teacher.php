<?php
include '../db/config.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['teacher_id']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Sanitize inputs
    $teacherId = htmlspecialchars($_POST['teacher_id'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: ../view/teacher-login.php");
        exit();
    }

    // Validate teacher ID format
    if (!preg_match("/^TEACH-\d{3}$/i", $teacherId)) {
        $_SESSION['error'] = "Invalid teacher ID format";
        header("Location: ../view/teacher-login.php");
        exit();
    }

    try {
        // Check if user exists with given email and is a teacher
        $stmt = $conn->prepare("SELECT u.user_id, u.password, t.teacher_id, t.first_name 
                               FROM users u 
                               JOIN teachers t ON u.user_id = t.user_id 
                               WHERE u.email = ? AND u.user_type = 'teacher'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify teacher ID matches
            if ($user['teacher_id'] !== $teacherId) {
                $_SESSION['error'] = "Invalid teacher ID";
                header("Location: ../view/teacher-login.php");
                exit();
            }

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['teacher_id'] = $user['teacher_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['user_type'] = 'teacher';
                //check if teacher is class teacher
                $stmt = $conn->prepare("SELECT is_class_teacher FROM teachers WHERE teacher_id = ?");
                $stmt->bind_param("s", $teacherId);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                if ($user['is_class_teacher']) {
                    header("Location: ../view/class-teacher-dashboard.php");
                } else {
                    header("Location: ../view/non-class-teacher-dashboard.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "Invalid password";
                header("Location: ../view/teacher-login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Teacher not found";
            header("Location: ../view/teacher-login.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Login failed: " . $e->getMessage();
        header("Location: ../view/teacher-login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Please fill in all required fields";
    header("Location: ../view/teacher-login.php");
    exit();
}
