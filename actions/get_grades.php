<?php
require_once('../db/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['student_id']) && isset($_GET['course_code'])) {
    $student_id = $_GET['student_id'];
    $course_code = $_GET['course_code'];


    $sql = "SELECT assignment_score, test_score, mid_term_score, exam_score 
            FROM grades 
            WHERE student_id = ? AND course_code = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $student_id, $course_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $grades = $result->fetch_assoc();

    echo json_encode($grades);
} else {
    echo json_encode(['error' => "Missing required parameters: student_id and course_code"]);
}
