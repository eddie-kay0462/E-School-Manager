<?php
session_start();
require_once('../db/config2.php');

// Check if user is logged in and is either a teacher or parent
if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], ['teacher', 'parent'])) {
    header('Location: ../index.php');
    exit();
}

$student_id = $_GET['student_id'];
$class_id = $_GET['class_id'];

// Security checks based on user type
if ($_SESSION['user_type'] === 'parent') {
    // Verify parent is authorized to view this student's report
    $sql = "SELECT ward_id FROM parents WHERE parent_id = ? AND ward_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['user_id'], $student_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        header('Location: parent-login.php?error=unauthorized');
        exit();
    }
} else if ($_SESSION['user_type'] === 'teacher') {
    // Verify teacher has access to this class
    $sql = "SELECT class_id FROM classes WHERE class_teacher_id = ? AND class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['user_id'], $class_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        // Check if teacher teaches any subjects in this class
        $sql = "SELECT tc.course_code 
                FROM teacher_courses tc
                INNER JOIN grades g ON tc.course_code = g.course_code
                WHERE tc.teacher_id = ? AND g.class_id = ?
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $_SESSION['user_id'], $class_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            header('Location: class-teacher-dashboard.php?error=unauthorized');
            exit();
        }
    }
}

// Get student details
$sql = "SELECT s.*, c.class_name 
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

// Get teacher remarks for current year
$sql = "SELECT r.remark, CONCAT(t.first_name, ' ', t.last_name) as teacher_name 
        FROM remarks r
        LEFT JOIN teachers t ON r.teacher_id = t.teacher_id 
        WHERE r.student_id = ? AND r.academic_year = '2023/2024'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$remarks_result = $stmt->get_result();
$remarks_data = $remarks_result->fetch_assoc();
$remarks = $remarks_data['remark'] ?? '';
$remark_teacher = $remarks_data['teacher_name'] ?? '';

// Handle saving remarks if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user_type'] === 'teacher') {
    $new_remark = $_POST['remarks'];
    $academic_year = '2023/2024';

    // Check if remark exists
    $check_sql = "SELECT remark_id FROM remarks WHERE student_id = ? AND academic_year = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $student_id, $academic_year);
    $check_stmt->execute();
    $existing = $check_stmt->get_result()->fetch_assoc();

    if ($existing) {
        // Update existing remark
        $update_sql = "UPDATE remarks SET remark = ?, teacher_id = ? WHERE student_id = ? AND academic_year = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssss", $new_remark, $_SESSION['user_id'], $student_id, $academic_year);
        $update_stmt->execute();
    } else {
        // Insert new remark
        $insert_sql = "INSERT INTO remarks (student_id, teacher_id, academic_year, remark) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", $student_id, $_SESSION['user_id'], $academic_year, $new_remark);
        $insert_stmt->execute();
    }

    $remarks = $new_remark;
}
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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

            .navbar,
            .print-button,
            footer {
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
                    <?php if ($_SESSION['user_type'] === 'teacher'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="class-teacher-dashboard.php">Dashboard</a>
                        </li>
                    <?php endif; ?>
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
                <p>Class Teacher: <?php
                                    $teacher_sql = "SELECT CONCAT(t.first_name, ' ', t.last_name) as teacher_name 
                                  FROM teachers t 
                                  INNER JOIN classes c ON t.teacher_id = c.class_teacher_id 
                                  WHERE c.class_id = ?";
                                    $teacher_stmt = $conn->prepare($teacher_sql);
                                    $teacher_stmt->bind_param("s", $class_id);
                                    $teacher_stmt->execute();
                                    $teacher_result = $teacher_stmt->get_result();
                                    $teacher_name = $teacher_result->fetch_assoc()['teacher_name'] ?? 'Not Assigned';
                                    echo htmlspecialchars($teacher_name);
                                    ?></p>
                <?php if ($_SESSION['user_type'] === 'teacher'): ?>
                    <form method="POST">
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Enter remarks here..."><?php echo htmlspecialchars($remarks); ?></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Save Remarks</button>
                    </form>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-2"><strong>Remark by:</strong> <?php echo htmlspecialchars($remark_teacher); ?></p>
                            <p class="mb-0"><?php echo htmlspecialchars($remarks); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print Report Card
                </button>
                <?php if ($_SESSION['user_type'] === 'teacher'): ?>
                    <a href="report-card.php?class_id=<?php echo $class_id; ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Class Report
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>