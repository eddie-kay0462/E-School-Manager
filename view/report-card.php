<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../db/config2.php');

// Get class ID from URL parameter
$class_id = $_GET['class_id'];

// Get class details
$sql = "SELECT c.*, CONCAT(t.first_name, ' ', t.last_name) as teacher_name 
        FROM classes c
        LEFT JOIN teachers t ON c.class_teacher_id = t.teacher_id 
        WHERE c.class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $class_id);
$stmt->execute();
$class = $stmt->get_result()->fetch_assoc();

// Get all students in the class with their grades
$sql = "SELECT s.student_id, s.first_name, s.last_name,
        c.course_code, c.course_name,
        COALESCE(g.assignment_score, 0) as assignment_score,
        COALESCE(g.test_score, 0) as test_score,
        COALESCE(g.mid_term_score, 0) as mid_term_score,
        COALESCE(g.exam_score, 0) as exam_score
        FROM students s
        CROSS JOIN courses c
        LEFT JOIN grades g ON s.student_id = g.student_id 
            AND g.course_code = c.course_code
        WHERE s.class_id = ? AND s.status = 'active'
        ORDER BY s.last_name, s.first_name, c.course_name";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $class_id);
$stmt->execute();
$result = $stmt->get_result();

// Organize data by student
$students = [];
while ($row = $result->fetch_assoc()) {
    $student_id = $row['student_id'];
    if (!isset($students[$student_id])) {
        $students[$student_id] = [
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'student_id' => $student_id,
            'courses' => []
        ];
    }

    $total = ((0.25 * $row['assignment_score']) +
        (0.25 * $row['test_score']) +
        (0.25 * $row['mid_term_score']) +
        (0.25 * $row['exam_score']));

    // Calculate letter grade
    $letter_grade = '';
    if ($total >= 70) $letter_grade = 'A';
    else if ($total >= 60) $letter_grade = 'B';
    else if ($total >= 50) $letter_grade = 'C';
    else if ($total >= 45) $letter_grade = 'D';
    else if ($total >= 40) $letter_grade = 'E';
    else $letter_grade = 'F';

    $students[$student_id]['courses'][$row['course_code']] = [
        'course_name' => $row['course_name'],
        'total_score' => $total,
        'letter_grade' => $letter_grade
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Report Cards - Josephus Memorial School</title>
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

    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <h2>Class Report Cards - <?php echo htmlspecialchars($class['class_name']); ?></h2>
                <p>Class Teacher: <?php echo htmlspecialchars($class['teacher_name']); ?></p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($students as $student): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo htmlspecialchars($student['name']); ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Score</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($student['courses'] as $course): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                            <td><?php echo number_format($course['total_score'], 2); ?></td>
                                            <td><?php echo $course['letter_grade']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a href="full_report_cards.php?student_id=<?php echo $student['student_id']; ?>&class_id=<?php echo $class_id; ?>"
                                class="btn btn-primary">
                                <i class="fas fa-file-alt me-2"></i>View Full Report
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>