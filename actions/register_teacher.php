<?php
// Start session
session_start();

// Include database connection
include '../db/config2.php';
// Initialize variables

error_reporting(E_ALL);
ini_set('display_errors', 1);
$errors = [];
$success = false;

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $courses = isset($_POST['courses']) ? (array)$_POST['courses'] : [];
    $courseIds = isset($_POST['courseIds']) ? (array)$_POST['courseIds'] : [];
    $isClassTeacher = $_POST['isClassTeacher'];
    $class = isset($_POST['class']) ? $_POST['class'] : null;


    // Print courses array properly
    if (!empty($courses)) {
        echo "Selected courses: " . implode(", ", $courses);
    } else {
        echo "No courses selected";
    }
    // Print courseIds array properly  
    if (!empty($courseIds)) {
        echo "Course IDs: " . implode(", ", $courseIds);
    } else {
        echo "No course IDs";
    }
    echo $isClassTeacher;
    echo $class;
    // Validate inputs
    if (empty($firstName)) {
        $errors['firstName'] = "First name is required";
    }
    if (empty($lastName)) {
        $errors['lastName'] = "Last name is required";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }
    if (empty($courses)) {
        $errors['courses'] = "Please select at least one course";
    }
    if (empty($courseIds)) {
        $errors['courseIds'] = "Please enter course IDs";
    }
    if (empty($isClassTeacher)) {
        $errors['isClassTeacher'] = "Please specify if you are a class teacher";
    }
    if ($isClassTeacher == 'yes' && empty($class)) {
        $errors['class'] = "Please select a class";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        try {
            // Begin transaction
            $pdo->beginTransaction();

            // Check if email already exists
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errors['email'] = "Email already registered";
                throw new Exception("Email already exists");
            }

            // Insert into users table
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, 'teacher')");
            $stmt->execute([$email, $hashedPassword]);
            $userId = $pdo->lastInsertId();

            // Insert into teachers table
            $stmt = $pdo->prepare("INSERT INTO teachers (user_id, first_name, last_name, is_class_teacher) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userId, $firstName, $lastName, $isClassTeacher == 'yes']);
            $teacherId = $pdo->lastInsertId();

            // If class teacher, insert into classes table
            if ($isClassTeacher == 'yes') {
                $stmt = $pdo->prepare("INSERT INTO classes (class_name, class_teacher_id, academic_year) VALUES (?, ?, ?)");
                $stmt->execute([$class, $teacherId, $academicYear]);
            }

            // Insert teacher courses
            $stmt = $pdo->prepare("INSERT INTO teacher_courses (teacher_id, course_id, class_id, academic_year) VALUES (?, ?, ?, ?)");
            foreach ($courses as $index => $course) {
                $courseId = $courseIds[$index];
                $stmt->execute([$teacherId, $courseId]);
            }

            // Commit transaction
            $pdo->commit();
            $success = true;

            // Redirect to login page
            header("Location: teacher-login.php?registered=true");
            exit();
        } catch (Exception $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            $errors['general'] = "Registration failed: " . $e->getMessage();
        }
    }

    
}
