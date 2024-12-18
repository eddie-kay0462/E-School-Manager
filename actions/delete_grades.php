<?php

session_start();
require_once '../db/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../index.php');
    exit;
}




$student_id = $_GET['student_id'];
$course_code = $_GET['course_code'];

$sql = "UPDATE grades SET 
        assignment_score = 0,
        test_score = 0,
        mid_term_score = 0,
        exam_score = 0
        WHERE student_id = ? AND course_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $student_id, $course_code);
$stmt->execute();

echo json_encode(['success' => true]);

$stmt->close();
$conn->close();
