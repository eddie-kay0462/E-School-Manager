<?php
include '../db/config2.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);



if (
    isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password'])
    && isset($_POST['teaching_classes']) && isset($_POST['teacher_id']) &&  isset($_POST['courses'])
) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $teachingClasses = $_POST['teaching_classes'];
    $teacherId = $_POST['teacher_id'];
    $courses = $_POST['courses'];
    $currentYear = date('Y');
    $academicYear = $currentYear . '-' . ($currentYear + 1);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if teacher_id already exists
        $checkStmt = $conn->prepare("SELECT teacher_id FROM teachers WHERE teacher_id = ?");
        $checkStmt->bind_param("s", $teacherId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Teacher ID " . $teacherId . " is already registered. Please choose a different ID.";
            header("Location: ../view/teacher-registration.php");
            exit();
        }

        // Check if email already exists
        $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $emailResult = $checkEmailStmt->get_result();

        if ($emailResult->num_rows > 0) {
            $_SESSION['error'] = "Email address " . $email . " is already registered. Please use a different email.";
            header("Location: ../view/teacher-registration.php");
            exit();
        }

        // If registering as class teacher, check if class already has a teacher
        if (isset($_POST['isClassTeacher']) && isset($_POST['class'])) {
            $class = $_POST['class'];
            $checkClassTeacherStmt = $conn->prepare("SELECT c.class_name, t.first_name, t.last_name 
                FROM classes c 
                JOIN teachers t ON c.class_teacher_id = t.teacher_id 
                WHERE c.class_name = ? AND c.academic_year = ?");
            $checkClassTeacherStmt->bind_param("ss", $class, $academicYear);
            $checkClassTeacherStmt->execute();
            $classTeacherResult = $checkClassTeacherStmt->get_result();

            if ($classTeacherResult->num_rows > 0) {
                $classTeacher = $classTeacherResult->fetch_assoc();
                $_SESSION['error'] = "Class " . strtoupper($class) . " already has a class teacher assigned (" .
                    $classTeacher['first_name'] . " " . $classTeacher['last_name'] . ").";
                header("Location: ../view/teacher-registration.php");
                exit();
            }
        }



        // If all checks pass, proceed with registration
        // Insert into users table first
        $stmt = $conn->prepare("INSERT INTO users (user_id, email, password, user_type, created_at) VALUES (?, ?, ?, 'teacher', NOW())");
        $stmt->bind_param("sss", $teacherId, $email, $password);
        $stmt->execute();

        // Insert into teachers table
        $isClassTeacher = isset($_POST['isClassTeacher']) ? 1 : 0;
        $stmt = $conn->prepare("INSERT INTO teachers (teacher_id, user_id, first_name, last_name, is_class_teacher) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $teacherId, $teacherId, $firstName, $lastName, $isClassTeacher);
        $stmt->execute();

        // If class teacher, insert into classes table
        if ($isClassTeacher && isset($_POST['class'])) {
            $class = $_POST['class'];
            $stmt2 = $conn->prepare("INSERT INTO classes (class_name, class_teacher_id, academic_year) VALUES (?, ?, ?)");
            $stmt2->bind_param("sss", $class, $teacherId, $academicYear);
            $stmt2->execute();
        }

        // Insert courses
        foreach ($courses as $course) {
            $courseCode = $course . "JH";
            $stmt = $conn->prepare("INSERT INTO courses (course_code, course_name) VALUES (?, ?) ON DUPLICATE KEY UPDATE course_name = course_name");
            $stmt->bind_param("ss", $courseCode, $course);
            $stmt->execute();
        }

        // Insert teacher-course assignments
        foreach ($courses as $course) {
            $courseCode = $course . "JH";
            $stmt = $conn->prepare("INSERT INTO teacher_courses (teacher_id, course_code, academic_year) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $teacherId, $courseCode, $academicYear);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "Teacher registered successfully!";

        if ($isClassTeacher) {
            header("Location: ../view/class-teacher-dashboard.php");
        } else {
            header("Location: ../view/non-class-teacher-dashboard.php");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error'] = "Registration failed: " . $e->getMessage();
        header("Location: ../view/teacher-registration.php");
    }
} else {
    $_SESSION['error'] = "Please fill in all required fields.";
    header("Location: ../view/teacher-registration.php");
}
exit();
