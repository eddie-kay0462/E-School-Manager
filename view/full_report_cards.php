<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../db/config2.php');

// Get student ID and class ID from URL parameters
$student_id = $_GET['student_id'];
$class_id = $_GET['class_id'];

// Get student details
$sql = "SELECT s.*, c.class_name, CONCAT(t.first_name, ' ', t.last_name) as teacher_name 
        FROM students s
        INNER JOIN classes c ON s.class_id = c.class_id
        LEFT JOIN teachers t ON c.class_teacher_id = t.teacher_id
        WHERE s.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

// Get student's grades for all courses
$sql = "SELECT c.course_code, c.course_name,
        COALESCE(g.assignment_score, 0) as assignment_score,
        COALESCE(g.test_score, 0) as test_score,
        COALESCE(g.mid_term_score, 0) as mid_term_score,
        COALESCE(g.exam_score, 0) as exam_score
        FROM courses c
        LEFT JOIN grades g ON c.course_code = g.course_code 
            AND g.student_id = ?
        ORDER BY c.course_name";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$grades = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate class position
$sql = "WITH StudentAverages AS (
    SELECT s.student_id,
           AVG((COALESCE(g.assignment_score, 0) + 
                COALESCE(g.test_score, 0) + 
                COALESCE(g.mid_term_score, 0) + 
                COALESCE(g.exam_score, 0)) / 4) as avg_score
    FROM students s
    LEFT JOIN grades g ON s.student_id = g.student_id
    WHERE s.class_id = ? AND s.status = 'active'
    GROUP BY s.student_id
)
SELECT COUNT(*) + 1 as position
FROM StudentAverages
WHERE avg_score > (
    SELECT avg_score 
    FROM StudentAverages 
    WHERE student_id = ?
)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $class_id, $student_id);
$stmt->execute();
$position = $stmt->get_result()->fetch_assoc();

// Get total number of students in class
$sql = "SELECT COUNT(*) as total FROM students WHERE class_id = ? AND status = 'active'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $class_id);
$stmt->execute();
$total_students = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-green: #2E7D32;
            --light-green: #4CAF50;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .bg-primary {
            background-color: var(--primary-green) !important;
        }

        .report-card {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-green);
        }

        .print-button {
            margin-top: 30px;
            width: 200px;
        }

        .table {
            background-color: #ffffff;
        }

        .table th {
            background-color: var(--primary-green);
            color: white;
        }

        .student-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .remarks-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        @media print {
            .navbar, .print-button, footer {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Josephus Memorial School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="class-teacher-dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../actions/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="report-card">
            <div class="school-header">
                <h2 class="mb-2">Josephus Memorial School</h2>
                <h1 class="mb-3">Student Report Card</h1>
                <p class="text-muted mb-0">Excellence in Education</p>
            </div>

            <div class="student-info">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="fas fa-user me-2"></i>Student Name: <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h4>
                        <h5><i class="fas fa-chalkboard me-2"></i>Class: <?php echo htmlspecialchars($student['class_name']); ?></h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5><i class="fas fa-calendar me-2"></i>Term: 2nd Term</h5>
                        <h5><i class="fas fa-clock me-2"></i>Academic Year: 2023/2024</h5>
                    </div>
                </div>
            </div>

            <h4 class="mb-3"><i class="fas fa-book me-2"></i>Courses and Grades</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Assignment (25%)</th>
                            <th>Test (25%)</th>
                            <th>Mid Term (25%)</th>
                            <th>Exam (25%)</th>
                            <th>Total Score</th>
                            <th>Letter Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): 
                            $total = ((0.25 * $grade['assignment_score']) +
                                    (0.25 * $grade['test_score']) +
                                    (0.25 * $grade['mid_term_score']) +
                                    (0.25 * $grade['exam_score']));
                            
                            // Calculate letter grade
                            if ($total >= 70) $letter_grade = 'A';
                            else if ($total >= 60) $letter_grade = 'B';
                            else if ($total >= 50) $letter_grade = 'C';
                            else if ($total >= 45) $letter_grade = 'D';
                            else if ($total >= 40) $letter_grade = 'E';
                            else $letter_grade = 'F';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($grade['course_name']); ?></td>
                            <td><?php echo $grade['assignment_score']; ?></td>
                            <td><?php echo $grade['test_score']; ?></td>
                            <td><?php echo $grade['mid_term_score']; ?></td>
                            <td><?php echo $grade['exam_score']; ?></td>
                            <td><?php echo number_format($total, 2); ?></td>
                            <td><?php echo $letter_grade; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4><i class="fas fa-trophy me-2"></i>Position in Class</h4>
                            <p class="h5 text-primary"><?php echo $position['position']; ?> out of <?php echo $total_students['total']; ?> students</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="remarks-section">
                <h4><i class="fas fa-comment me-2"></i>Class Teacher's Remarks</h4>
                <p>Class Teacher: <?php echo htmlspecialchars($student['teacher_name']); ?></p>
                <textarea class="form-control" rows="3" placeholder="Enter remarks here..."></textarea>
            </div>

            <div class="text-center">
                <button class="btn btn-primary print-button" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Report Card
                </button>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>