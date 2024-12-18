<?php
session_start();
require_once '../db/config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $enrollment_date = mysqli_real_escape_string($conn, $_POST['enrollment_date']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class']);

    // Validate inputs
    if (
        empty($student_id) || empty($first_name) || empty($last_name) ||
        empty($dob) || empty($gender) || empty($enrollment_date) || empty($class_id)
    ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: ../view/admin-dashboard.php");
        exit();
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update student record
        $query = "UPDATE students SET 
                  first_name = ?, 
                  last_name = ?,
                  date_of_birth = ?,
                  gender = ?,
                  enrollment_date = ?,
                  class_id = ?
                  WHERE student_id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssss",
            $first_name,
            $last_name,
            $dob,
            $gender,
            $enrollment_date,
            $class_id,
            $student_id
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to update student record: " . mysqli_stmt_error($stmt));
        }

        // Check if any rows were affected
        if (mysqli_stmt_affected_rows($stmt) == 0) {
            throw new Exception("No student record was updated. Student ID may not exist.");
        }

        // Update parent table
        $parent_query = "UPDATE parents SET 
                        ward_id = ? 
                        WHERE ward_id = ?";

        $parent_stmt = mysqli_prepare($conn, $parent_query);
        mysqli_stmt_bind_param(
            $parent_stmt,
            "ss",
            $student_id,
            $student_id
        );
        if (!mysqli_stmt_execute($parent_stmt)) {
            throw new Exception("Failed to update parent record: " . mysqli_stmt_error($parent_stmt));
        }

        // Update remarks table
        $remarks_query = "UPDATE remarks SET 
                         student_id = ?
                         WHERE student_id = ?";

        $remarks_stmt = mysqli_prepare($conn, $remarks_query);
        mysqli_stmt_bind_param(
            $remarks_stmt,
            "ss",
            $student_id,
            $student_id
        );
        if (!mysqli_stmt_execute($remarks_stmt)) {
            throw new Exception("Failed to update remarks record: " . mysqli_stmt_error($remarks_stmt));
        }

        // Commit transaction
        mysqli_commit($conn);
        $_SESSION['success'] = "Student and related records updated successfully";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        $_SESSION['error'] = "Error updating records: " . $e->getMessage();
    }

    // Close all statements
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($parent_stmt);
    mysqli_stmt_close($remarks_stmt);
    mysqli_close($conn);

    header("Location: ../view/admin-dashboard.php");
    exit();
} else {
    header("Location: ../view/admin-dashboard.php");
    exit();
}
