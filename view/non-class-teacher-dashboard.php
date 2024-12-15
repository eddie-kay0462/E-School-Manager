<!DOCTYPE html>
<?php
// Start session and include database connection
session_start();
require_once('../db/config2.php');

// Get teacher ID from session
$teacher_id = $_SESSION['user_id'];

// Get teacher's courses
$sql = "SELECT DISTINCT c.course_code, c.course_name 
        FROM courses c
        INNER JOIN teacher_courses tc ON c.course_code = tc.course_code
        WHERE tc.teacher_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Get teacher details
$sql = "SELECT first_name, last_name FROM teachers WHERE teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

// Get current academic year
$currentYear = date('Y');
$academicYear = $currentYear . '-' . ($currentYear + 1);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Josephus Memorial School</title>
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
    </style>
</head>

<body>
    <!-- Edit Grades Modal -->
    <div id="editGradesModal" class="modal">
        <div class="modal-content">
            <h3>Edit Grades for <span id="studentNameInModal"></span></h3>
            <form id="editGradesForm">
                <input type="hidden" id="studentId" name="studentId">
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
                            <div class="course-item" onclick="toggleClassLinks('<?php echo htmlspecialchars($course['course_code']); ?>')">
                                <i class="fas fa-book"></i>
                                <span><?php echo htmlspecialchars($course['course_name']); ?></span>
                            </div>
                            <div class="class-links" id="classes-<?php echo htmlspecialchars($course['course_code']); ?>">
                                <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss1', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 1</a>
                                <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss2', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 2</a>
                                <a href="#" onclick="showCourseRecords('<?php echo htmlspecialchars($course['course_name']); ?>-jss3', '<?php echo htmlspecialchars($course['course_code']); ?>')">JSS 3</a>
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

                <div class="card mb-4 d-none" id="courseRecords">
                    <div class="card-body">
                        <h2 id="courseTitle"></h2>
                        <p class="mb-0" id="courseMessage"></p>
                    </div>
                </div>

                <?php foreach ($courses as $course): ?>
                    <?php
                    $classes = ['jss1', 'jss2', 'jss3'];
                    foreach ($classes as $class):
                        // Get students for this class
                        $sql = "SELECT s.student_id, s.first_name, s.last_name 
                                FROM students s
                                INNER JOIN classes c ON s.class_id = c.class_id 
                                WHERE c.class_name = ? AND s.status = 'active'
                                ORDER BY s.last_name, s.first_name";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $class);
                        $stmt->execute();
                        $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    ?>
                        <div id="<?php echo htmlspecialchars($course['course_name']) . '-' . $class; ?>" class="tab-content card">
                            <div class="card-body">
                                <h2><?php echo htmlspecialchars($course['course_name']); ?> - <?php echo strtoupper($class); ?> Student Grades</h2>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Assignment Score (25%)</th>
                                            <th>Test Score (25%)</th>
                                            <th>Mid Term Score (25%)</th>
                                            <th>Exam Score (25%)</th>
                                            <th>Total Score (100%)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student):
                                            // Generate random initial grades for demonstration
                                            $assignment = rand(60, 95);
                                            $test = rand(60, 95);
                                            $midterm = rand(60, 95);
                                            $exam = rand(60, 95);
                                            $total = ($assignment + $test + $midterm + $exam) / 4;
                                            $studentFullName = htmlspecialchars($student['first_name'] . ' ' . $student['last_name']);
                                        ?>
                                            <tr>
                                                <td><?php echo $studentFullName; ?></td>
                                                <td><?php echo $assignment; ?></td>
                                                <td><?php echo $test; ?></td>
                                                <td><?php echo $midterm; ?></td>
                                                <td><?php echo $exam; ?></td>
                                                <td><?php echo number_format($total, 2); ?></td>
                                                <td class="action-icons">
                                                    <i class="fas fa-edit" title="Edit" onclick="openEditModal('<?php echo $student['student_id']; ?>', <?php echo $assignment; ?>, <?php echo $test; ?>, <?php echo $midterm; ?>, <?php echo $exam; ?>, '<?php echo $studentFullName; ?>')"></i>
                                                    <i class="fas fa-trash-alt" title="Delete"></i>
                                                </td>
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
    <script>
        function toggleClassLinks(courseCode) {
            const classLinks = document.getElementById(`classes-${courseCode}`);
            if (classLinks.style.display === 'block') {
                classLinks.style.display = 'none';
            } else {
                // Hide all other class links first
                document.querySelectorAll('.class-links').forEach(el => {
                    el.style.display = 'none';
                });
                classLinks.style.display = 'block';
            }
        }

        function showCourseRecords(courseName, courseCode) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected course tab
            document.getElementById(courseName).classList.add('active');

            // Update course info card
            const courseRecords = document.getElementById('courseRecords');
            const courseTitle = document.getElementById('courseTitle');
            const courseMessage = document.getElementById('courseMessage');

            courseTitle.textContent = courseName;
            courseMessage.textContent = `Viewing records for ${courseName}`;
            courseRecords.classList.remove('d-none');
        }

        function openEditModal(studentId, assignment, test, midterm, exam, studentName) {
            const modal = document.getElementById('editGradesModal');
            document.getElementById('studentId').value = studentId;
            document.getElementById('assignmentScore').value = assignment;
            document.getElementById('testScore').value = test;
            document.getElementById('midtermScore').value = midterm;
            document.getElementById('examScore').value = exam;
            document.getElementById('studentNameInModal').textContent = studentName;
            modal.style.display = 'block';
        }

        function closeEditModal() {
            const modal = document.getElementById('editGradesModal');
            modal.style.display = 'none';
        }

        document.getElementById('editGradesForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the form data to the server
            // For now, we'll just close the modal
            closeEditModal();
        });

        // Show first course tab by default
        document.addEventListener('DOMContentLoaded', () => {
            const firstCourse = document.querySelector('.course-item');
            if (firstCourse) {
                const courseName = firstCourse.querySelector('span').textContent;
                const courseCode = firstCourse.parentElement.querySelector('.class-links').id.replace('classes-', '');
                showCourseRecords(courseName + '-JSS1', courseCode);
            }
        });
    </script>
</body>

</html>