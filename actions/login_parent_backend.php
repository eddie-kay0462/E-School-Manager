<?php
session_start();
require_once('../db/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $wardId = $_POST['wardId'];

    // Verify parent credentials and ward relationship
    $sql = "SELECT parent_id, ward_id, full_name 
            FROM parents 
            WHERE ward_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $wardId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['parent_id'];
        $_SESSION['user_type'] = 'parent';

        // Redirect to the report card page with the ward's ID
        // Get student's class ID
        $sql = "SELECT class_id FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $wardId);
        $stmt->execute();
        $class_result = $stmt->get_result();
        $class_row = $class_result->fetch_assoc();

        header("Location: ../view/full_report_cards.php?student_id=" . $wardId . "&class_id=" . $class_row['class_id']);
        // header("Location : ../view/full_report_card.php?student_id=" . $wardId);
        exit();
    }

    // If login fails
    header("Location: ../view/parent-login.php?error=invalid");
    exit();
}
