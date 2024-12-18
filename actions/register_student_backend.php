<?php
session_start();
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = $_POST['student_id'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $date_of_birth = $_POST['dob'];
    $gender = $_POST['gender'];
    $class_id = $_POST['class']; // Get class name from form
    $enrollment_date = $_POST['enrollment_date'];

    try {
        $conn->begin_transaction();

        // Check if student ID already exists
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Student ID already exists. Please enter a unique ID.";
            header("Location: ../view/admin-dashboard.php");
            exit();
        }

        // Get class_id from class name
        $stmt = $conn->prepare("SELECT class_id FROM classes WHERE class_id = ?");
        $stmt->bind_param("s", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $class_result = $result->fetch_assoc();

        if (!$class_result) {
            $_SESSION['error'] = "Invalid class selected";
            header("Location: ../view/admin-dashboard.php");
            exit();
        }

        $class_id = $class_result['class_id'];

        // Insert into students table
        $stmt = $conn->prepare("INSERT INTO students (student_id, first_name, last_name, date_of_birth, gender, class_id, enrollment_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param("sssssss", $student_id, $firstname, $lastname, $date_of_birth, $gender, $class_id, $enrollment_date);
        $stmt->execute();

        $conn->commit();

        $_SESSION['success'] = "Student registration successful!";
        header("Location: ../view/admin-dashboard.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Registration failed: " . $e->getMessage();
        header("Location: ../view/admin-dashboard.php");
        exit();
    }
} else {
    header("Location: ../view/admin-dashboard.php");
    exit();
}
