<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> -->
    <style>
        .stats-card {
            transition: transform 0.3s ease-in-out;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .stats-label {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .dashboard-header {
            background: linear-gradient(45deg, #4b6cb7, #182848);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .welcome-message {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .date-time {
            font-size: 1.1rem;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require_once('../db/config.php');
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
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
                        <a class="nav-link" href="../actions/logout.php" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#dashboard" onclick="showSection('dashboard')">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#teachers" onclick="showSection('teachers')">
                                <i class="fas fa-chalkboard-teacher"></i> Teachers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#students" onclick="showSection('students')">
                                <i class="fas fa-user-graduate"></i> Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#classes" onclick="showSection('classes')">
                                <i class="fas fa-school"></i> Classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#courses" onclick="showSection('courses')">
                                <i class="fas fa-book"></i> Courses
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <label for="">

            </label>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Dashboard Section -->
                <section id="dashboard-section">
                    <div class="dashboard-header mt-4">
                        <h1 class="welcome-message">Welcome to Admin Dashboard</h1>
                        <p class="date-time" id="currentDateTime"></p>
                    </div>

                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">';
                        echo htmlspecialchars($_SESSION['error']);
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        echo '<script>
                                setTimeout(function() {
                                    document.getElementById("errorAlert").remove();
                                }, 2000);
                              </script>';
                        unset($_SESSION['error']);
                    }

                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">';
                        echo htmlspecialchars($_SESSION['success']);
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        echo '<script>
                                setTimeout(function() {
                                    document.getElementById("successAlert").remove();
                                }, 2000);
                              </script>';
                        unset($_SESSION['success']);
                    }
                    ?>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stats-label">Total Students</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM students";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="stats-number"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <div class="stats-icon">
                                            <i class="fas fa-user-graduate fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stats-label">Total Teachers</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM teachers";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="stats-number"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <div class="stats-icon">
                                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stats-label">Total Classes</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM classes";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="stats-number"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <div class="stats-icon">
                                            <i class="fas fa-school fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="stats-label">Total Courses</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM courses";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="stats-number"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <div class="stats-icon">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function updateDateTime() {
                            const now = new Date();
                            const options = {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            };
                            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
                        }

                        updateDateTime();
                        setInterval(updateDateTime, 1000);
                    </script>
                </section>

                <!-- Teachers Section -->
                <section id="teachers-section" style="display: none;">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage Teachers</h1>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                            <i class="fas fa-plus"></i> Add New Teacher
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="teachersTable">
                            <thead>
                                <tr>
                                    <th>Teacher ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class Teacher</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM teachers";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['teacher_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                                    echo "<td>" . ($row['is_class_teacher'] ? 'Yes' : 'No') . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-primary' onclick='editTeacher(\"" . $row['teacher_id'] . "\")'><i class='fas fa-edit'></i></button>
                                            <button class='btn btn-sm btn-danger' onclick='deleteTeacher(\"" . $row['teacher_id'] . "\")'><i class='fas fa-trash'></i></button>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Classes Section -->
                <section id="classes-section" style="display: none;">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage Classes</h1>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                            <i class="fas fa-plus"></i> Add New Class
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="classesTable">
                            <thead>
                                <tr>
                                    <th>Class ID</th>
                                    <th>Class Name</th>
                                    <th>Class Teacher Name</th>
                                    <th>Class Teacher ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT c.*, CONCAT(t.first_name, ' ', t.last_name) as teacher_name 
                                         FROM classes c 
                                         LEFT JOIN teachers t ON c.class_teacher_id = t.teacher_id";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['class_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['teacher_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['class_teacher_id']) . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-primary' onclick='editClass(\"" . $row['class_id'] . "\")'><i class='fas fa-edit'></i></button>
                                            <button class='btn btn-sm btn-danger' onclick='deleteClass(\"" . $row['class_id'] . "\")'><i class='fas fa-trash'></i></button>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Courses Section -->
                <section id="courses-section" style="display: none;">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage Courses</h1>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                            <i class="fas fa-plus"></i> Add New Course
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="coursesTable">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Teacher Name</th>
                                    <th>Teacher ID</th>
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT c.course_code, c.course_name, 
                                                t.teacher_id, t.first_name, t.last_name
                                         FROM courses c
                                         LEFT JOIN teacher_courses tc ON c.course_code = tc.course_code
                                         LEFT JOIN teachers t ON tc.teacher_id = t.teacher_id";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['teacher_id']) . "</td>";
                                    // echo "<td>
                                    //         <button class='btn btn-sm btn-primary' onclick='editCourse(\"" . $row['course_code'] . "\")'><i class='fas fa-edit'></i></button>
                                    //         <button class='btn btn-sm btn-danger' onclick='deleteCourse(\"" . $row['course_code'] . "\")'><i class='fas fa-trash'></i></button>
                                    //       </td>";
                                    // echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Students Section -->
                <section id="student-registration-section" style="display: none;">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage Students</h1>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-plus"></i> Add New Student
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Enrollment Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT s.*, c.class_name, CONCAT(s.first_name, ' ', s.last_name) as student_name 
                                         FROM students s 
                                         LEFT JOIN classes c ON s.class_id = c.class_id";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['enrollment_date']) . "</td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-primary' onclick='openEditStudentModal(\"" . $row['student_id'] . "\")' data-bs-toggle='modal' data-bs-target='#editStudentModal'><i class='fas fa-edit'></i></button>
                                            <button class='btn btn-sm btn-danger' onclick='deleteStudent(\"" . $row['student_id'] . "\")'><i class='fas fa-trash'></i></button>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Add Teacher Modal -->
                <div class="modal fade" id="addTeacherModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Teacher</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addTeacherForm" action="../actions/add_teacher.php" method="post">
                                    <div class="mb-3">
                                        <label for="teacherId" class="form-label">Teacher ID</label>
                                        <input type="text" class="form-control" id="teacherId" name="teacher_id" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="teacherFirstName" name="first_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="teacherLastName" name="last_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isClassTeacher" name="is_class_teacher">
                                            <label class="form-check-label" for="isClassTeacher">
                                                Is Class Teacher
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Teacher</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Student Modal -->
                <div class="modal fade" id="addStudentModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register New Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="studentRegistrationForm" action="../actions/register_student_backend.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="studentId" class="form-label">Student ID</label>
                                            <input type="text" class="form-control" id="studentId" name="student_id" required>
                                            <div class="text-danger invalid-feedback" id="studentIdError">
                                                Please enter a valid student ID (alphanumeric characters only)
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="admissionDate" class="form-label">Enrolment Date</label>
                                            <input type="date" class="form-control" id="enrollmentDate" name="enrollment_date" required>
                                            <div class="text-danger invalid-feedback" id="enrollmentDateError">
                                                Please select a valid enrolment date
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                                            <div class="text-danger invalid-feedback" id="firstNameError" style="display: none;">
                                                Please enter a valid first name (letters only)
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                                            <div class="text-danger invalid-feedback" id="lastNameError" style="display: none;">
                                                Please enter a valid last name (letters only)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" required>
                                            <div class="text-danger invalid-feedback" id="dobError" style="display: none;">
                                                Please select a valid date of birth (must be between 10-28 years old)
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="">Choose...</option>
                                                <option value="male">male</option>
                                                <option value="female">female</option>
                                                <option value="other">other</option>
                                            </select>
                                            <div class="text-danger invalid-feedback" id="genderError" style="display: none;">
                                                Please select a gender
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Class</label>
                                            <div class="mt-2">
                                                <?php
                                                $query = "SELECT * FROM classes";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<div class='form-check'>";
                                                    echo "<input class='form-check-input' type='radio' name='class' id='class" . $row['class_id'] . "' value='" . $row['class_id'] . "' required>";
                                                    echo "<label class='form-check-label' for='class" . $row['class_id'] . "' >" . htmlspecialchars($row['class_name']) . "</label>";
                                                    echo "</div>";
                                                }
                                                ?>
                                            </div>
                                            <div class="text-danger invalid-feedback" id="classError" style="display: none;">
                                                Please select a class
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Register Student</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Student Modal -->
                <div class="modal fade" id="editStudentModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editStudentForm" action="../actions/update_student.php" method="post">
                                    <input type="hidden" id="edit_student_id" name="student_id">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_student_id" class="form-label">Student ID</label>
                                            <input type="text" class="form-control" id="edit_student_id" name="student_id" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_dob" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="edit_dob" name="dob" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_gender" class="form-label">Gender</label>
                                            <select class="form-select" id="edit_gender" name="gender" required>
                                                <option value="male">male</option>
                                                <option value="female">female</option>
                                                <option value="other">other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="edit_enrollment_date" class="form-label">Enrollment Date</label>
                                            <input type="date" class="form-control" id="edit_enrollment_date" name="enrollment_date" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Class</label>
                                            <div class="mt-2">
                                                <?php
                                                $query = "SELECT * FROM classes";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<div class='form-check'>";
                                                    echo "<input class='form-check-input edit-class-radio' type='radio' name='class' id='edit_class" . $row['class_id'] . "' value='" . $row['class_id'] . "' required>";
                                                    echo "<label class='form-check-label' for='edit_class" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . "</label>";
                                                    echo "</div>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Student</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/admin-dashboard.js"></script>
    <script>
        function showSection(sectionName) {
            // Hide all sections
            document.getElementById('dashboard-section').style.display = 'none';
            document.getElementById('teachers-section').style.display = 'none';
            document.getElementById('student-registration-section').style.display = 'none';
            document.getElementById('classes-section').style.display = 'none';
            document.getElementById('courses-section').style.display = 'none';

            // Show selected section
            if (sectionName === 'teachers') {
                document.getElementById('teachers-section').style.display = 'block';
            } else if (sectionName === 'dashboard') {
                document.getElementById('dashboard-section').style.display = 'block';
            } else if (sectionName === 'students') {
                document.getElementById('student-registration-section').style.display = 'block';
            } else if (sectionName === 'classes') {
                document.getElementById('classes-section').style.display = 'block';
            } else if (sectionName === 'courses') {
                document.getElementById('courses-section').style.display = 'block';
            }
        }

        // Initialize DataTables
        $(document).ready(function() {
            $('#teachersTable').DataTable();
            $('#classesTable').DataTable();
            $('#coursesTable').DataTable();
        });

        function editTeacher(teacherId) {
            // Implement edit functionality
            console.log('Edit teacher:', teacherId);
        }

        function deleteTeacher(teacherId) {
            if (confirm('Are you sure you want to delete this teacher?')) {
                // Implement delete functionality
                console.log('Delete teacher:', teacherId);
            }
        }

        function editClass(classId) {
            // Implement edit functionality
            console.log('Edit class:', classId);
        }

        function deleteClass(classId) {
            if (confirm('Are you sure you want to delete this class?')) {
                // Implement delete functionality
                console.log('Delete class:', classId);
            }
        }

        function updateTeacher(teacherId) {

        }
    </script>
</body>

</html>