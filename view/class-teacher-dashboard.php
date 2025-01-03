<!DOCTYPE html>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../db/config.php');

// Get teacher ID from session
$teacher_id = $_SESSION['user_id'];

// Get teacher's class
$sql = "SELECT class_id, class_name FROM classes WHERE class_teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$teacher_class = $stmt->get_result()->fetch_assoc();

// Get all courses
$sql = "SELECT DISTINCT c.course_code, c.course_name,
        CASE WHEN tc.teacher_id = ? THEN 1 ELSE 0 END as is_teacher 
        FROM courses c
        LEFT JOIN teacher_courses tc ON c.course_code = tc.course_code AND tc.teacher_id = ?
        ORDER BY c.course_name";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $teacher_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Get teacher details
$sql = "SELECT first_name, last_name FROM teachers WHERE teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Teacher Dashboard - Josephus Memorial School</title>
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

        .sidebar {
            background-color: var(--primary-green);
            min-height: calc(100vh - 56px - 56px);
        }

        .course-item {
            color: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .course-item:hover {
            background-color: var(--light-green);
        }

        .course-item i {
            margin-right: 10px;
        }

        .class-links {
            padding-left: 30px;
            display: none;
        }

        .class-links a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 5px 0;
            font-size: 0.9em;
        }

        .class-links a:hover {
            color: #ddd;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .grade-input {
            width: 60px;
            text-align: center;
        }

        .action-icons i {
            cursor: pointer;
            margin: 0 5px;
            font-size: 1.1em;
        }

        .fa-edit {
            color: #2196F3;
        }

        .fa-trash-alt {
            color: #F44336;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        /* Style for read-only courses */
        .read-only {
            opacity: 0.7;
        }

        .read-only .action-icons {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Edit Grades Modal -->
    <div id="editGradesModal" class="modal">
        <div class="modal-content">
            <h3>Edit Grades for <span id="studentNameInModal"></span></h3>
            <form id="editGradesForm">
                <input type="hidden" id="classId" name="classId" value="some_class_id">
                <input type="hidden" id="courseCode" name="courseCode">
                <input type="text" id="studentId" name="studentId" readonly class="form-control">
                <div class="mb-3">
                    <label for="assignmentScore" class="form-label">Assignment Score (25%)</label>
                    <input type="number" class="form-control" id="assignmentScore" name="assignmentScore" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label for="testScore" class="form-label">Test Score (25%)</label>
                    <input type="number" class="form-control" id="testScore" name="testScore" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label for="midtermScore" class="form-label">Mid Term Score (25%)</label>
                    <input type="number" class="form-control" id="midtermScore" name="midtermScore" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label for="examScore" class="form-label">Exam Score (25%)</label>
                    <input type="number" class="form-control" id="examScore" name="examScore" min="0" max="100" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Josephus Memorial School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../actions/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <div class="text-white text-center mb-4 border-bottom pb-3">
                    <h3>Courses</h3>
                </div>
                <div>
                    <?php foreach ($courses as $course): ?>
                        <div>
                            <div class="course-item <?php echo $course['is_teacher'] ? '' : 'read-only'; ?>"
                                onclick="toggleClassLinks('<?php echo htmlspecialchars($course['course_code']); ?>')">
                                <i class="fas fa-book"></i>
                                <span><?php echo htmlspecialchars($course['course_name']); ?></span>
                                <?php if (!$course['is_teacher']): ?>
                                    <small>(View Only)</small>
                                <?php endif; ?>
                            </div>
                            <div class="class-links" id="classes-<?php echo htmlspecialchars($course['course_code']); ?>">
                                <?php if ($course['is_teacher']): ?>
                                    <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss1', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 1</a>
                                    <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss2', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 2</a>
                                    <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss3', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 3</a>
                                <?php else: ?>
                                    <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-<?php echo strtolower($teacher_class['class_name']); ?>', '<?php echo htmlspecialchars($course['course_code']); ?>')"><?php echo strtoupper($teacher_class['class_name']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 p-4 bg-light">
                <div class="card mb-4">
                    <div class="card-body">
                        <h1>Welcome, <?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></h1>
                        <p class="mb-0">Subject Teacher</p>
                    </div>
                </div>

                <!-- Add this new card for Report Cards -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Class Management</h3>
                        <p>Access student report cards and academic records.</p>
                        <a href="report-card.php?class_id=<?php echo $teacher_class['class_id']; ?>" class="btn btn-primary">
                            <i class="fas fa-file-alt me-2"></i>View Report Cards
                        </a>
                    </div>
                </div>

                <div class="card mb-4 d-none" id="courseRecords">
                    <div class="card-body">
                        <h2 id="courseTitle"></h2>
                        <p class="mb-0" id="courseMessage"></p>
                    </div>
                </div>

                <?php foreach ($courses as $course): ?>
                    <?php
                    // For courses they teach, show all classes
                    // For other courses, only show their assigned class
                    $classes = $course['is_teacher'] ? ['jss1', 'jss2', 'jss3'] : [strtolower($teacher_class['class_name'])];

                    foreach ($classes as $class):
                        // Get students and their grades for this class and course
                        $sql = "SELECT s.student_id, s.first_name, s.last_name,
                                COALESCE(g.assignment_score, 0) as assignment_score,
                                COALESCE(g.test_score, 0) as test_score,
                                COALESCE(g.mid_term_score, 0) as mid_term_score,
                                COALESCE(g.exam_score, 0) as exam_score
                                FROM students s
                                INNER JOIN classes c ON s.class_id = c.class_id 
                                LEFT JOIN grades g ON s.student_id = g.student_id 
                                    AND g.course_code = ?
                                    AND g.class_id = c.class_id
                                WHERE c.class_name = ? AND s.status = 'active'
                                ORDER BY s.last_name, s.first_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $course['course_code'], $class);
                        $stmt->execute();
                        $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    ?>
                        <div id="<?php echo htmlspecialchars($course['course_name']) . '-' . $class; ?>"
                            class="tab-content card <?php echo $course['is_teacher'] ? '' : 'read-only'; ?>">
                            <div class="card-body">
                                <h2><?php echo htmlspecialchars($course['course_name']); ?> - <?php echo strtoupper($class); ?> Student Grades</h2>
                                <?php if (!$course['is_teacher']): ?>
                                    <div class="alert alert-info">View Only - You are not the teacher for this course</div>
                                <?php endif; ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Assignment Score (25%)</th>
                                            <th>Test Score (25%)</th>
                                            <th>Mid Term Score (25%)</th>
                                            <th>Exam Score (25%)</th>
                                            <th>Total Score (100%)</th>
                                            <?php if ($course['is_teacher']): ?>
                                                <th>Actions</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student):
                                            $total =  ((0.25 * $student['assignment_score']) + (0.25 * $student['test_score']) +
                                                (0.25 * $student['mid_term_score']) + (0.25 * $student['exam_score']));
                                            $studentFullName = htmlspecialchars($student['first_name'] . ' ' . $student['last_name']);
                                        ?>
                                            <tr data-id="<?php echo htmlspecialchars($student['student_id']); ?>">
                                                <td><?php echo $studentFullName; ?></td>
                                                <td><?php echo $student['assignment_score']; ?></td>
                                                <td><?php echo $student['test_score']; ?></td>
                                                <td><?php echo $student['mid_term_score']; ?></td>
                                                <td><?php echo $student['exam_score']; ?></td>
                                                <td><?php echo number_format($total, 2); ?></td>
                                                <?php if ($course['is_teacher']): ?>
                                                    <td class="action-icons">
                                                        <i class="fas fa-plus-circle" title="Add Grade"
                                                            onclick="openAddModal('<?php echo $student['student_id']; ?>', 
                                                                        '<?php echo $course['course_code']; ?>', 
                                                                        '<?php echo $studentFullName; ?>')"></i>
                                                        <i class="fas fa-edit" title="Edit"
                                                            onclick="openEditModal('<?php echo $student['student_id']; ?>', 
                                                                        '<?php echo $course['course_code']; ?>', 
                                                                        '<?php echo $studentFullName; ?>')"></i>
                                                        <i class="fas fa-trash-alt" title="Delete"
                                                            data-id="<?php echo htmlspecialchars($student['student_id']); ?>"
                                                            onclick="deleteGrade('<?php echo htmlspecialchars($student['student_id']); ?>', '<?php echo htmlspecialchars($course['course_code']); ?>')"></i>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- include the link to the script files -->
    <script src="../assets/js/non-class-teacher-dashboard.js"></script>
</body>

</html>