<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../db/config.php';

// Ensure only JSON is output
header('Content-Type: application/json');

// Start output buffering to prevent any accidental output
ob_start();

// Get the data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data is empty or any required field is missing
$required_fields = ['studentId', 'courseCode', 'assignmentScore', 'testScore', 'midtermScore', 'examScore'];
foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
        echo json_encode(['success' => false, 'message' => "Field '$field' is required."]);
        exit();
    }
}

try {
    session_start();
    $teacher_id = $_SESSION['user_id'];
    $student_id = $data['studentId'];
    $course_code = $data['courseCode'];
    $assignment_score = $data['assignmentScore'];
    $test_score = $data['testScore'];
    $mid_term_score = $data['midtermScore'];
    $exam_score = $data['examScore'];

    // First, find the correct class_id for the student
    $class_sql = "SELECT c.class_id, c.class_name 
                  FROM students s
                  JOIN classes c ON s.class_id = c.class_id
                  WHERE s.student_id = ?";
    $class_stmt = $conn->prepare($class_sql);
    $class_stmt->bind_param("s", $student_id);
    $class_stmt->execute();
    $class_result = $class_stmt->get_result();

    if ($class_result->num_rows === 0) {
        throw new Exception("No class found for student ID: $student_id");
    }

    $class_row = $class_result->fetch_assoc();
    $class_id = $class_row['class_id'];

    // First check if grade exists
    $check_sql = "SELECT * FROM grades 
                  WHERE student_id = ? 
                  AND teacher_id = ? 
                  AND course_code = ? 
                  AND class_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ssss", $student_id, $teacher_id, $course_code, $class_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing grades
        $sql = "UPDATE grades SET 
                assignment_score = ?,
                test_score = ?,
                mid_term_score = ?,
                exam_score = ?
                WHERE student_id = ? 
                AND teacher_id = ? 
                AND course_code = ? 
                AND class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssss",
            $assignment_score,
            $test_score,
            $mid_term_score,
            $exam_score,
            $student_id,
            $teacher_id,
            $course_code,
            $class_id
        );
    } else {
        // Insert new grades
        $sql = "INSERT INTO grades (
                student_id, 
                teacher_id, 
                course_code, 
                assignment_score, 
                test_score, 
                mid_term_score, 
                exam_score, 
                class_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssss",
            $student_id,
            $teacher_id,
            $course_code,
            $assignment_score,
            $test_score,
            $mid_term_score,
            $exam_score,
            $class_id
        );
    }

    $stmt->execute();

    // Check for any execution errors
    if ($stmt->error) {
        throw new Exception("Database error: " . $stmt->error);
    }

    // Send a success response
    echo json_encode([
        "success" => true,
        "message" => "Grades saved successfully!",
        "class_id" => $class_id,
        "class_name" => $class_row['class_name']
    ]);
} catch (Exception $e) {
    // Send an error response
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

// End output buffering and clean output
ob_end_flush();
