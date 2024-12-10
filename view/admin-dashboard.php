<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <?php
    session_start();
    require_once('../db/config2.php');
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
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

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Dashboard Section -->
                <section id="dashboard-section">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Admin Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                        </div>
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
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase">Total Students</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM students";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="mb-0"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase">Total Teachers</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM teachers";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="mb-0"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase">Total Classes</h6>
                                            <?php
                                            $query = "SELECT COUNT(*) as count FROM classes";
                                            $result = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <h2 class="mb-0"><?php echo $row['count']; ?></h2>
                                        </div>
                                        <i class="fas fa-school fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-uppercase">Total Courses</h6>
                                            <h2 class="mb-0">
                                                <?php
                                                $query = "SELECT COUNT(*) as count FROM courses";
                                                $result = mysqli_query($conn, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                echo $row['count'];
                                                ?>
                                            </h2>
                                        </div>
                                        <i class="fas fa-book fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" required>
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

                <!-- Student Registration Form -->
                <div class="card mb-4" id="student-registration-section" style="display: none;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Register New Student</h5>
                    </div>
                    <div class="card-body">
                        <form id="studentRegistrationForm" action="../actions/register_student_backend.php" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="studentId" class="form-label">Student ID</label>
                                    <input type="text" class="form-control" id="studentId" name="student_id" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="admissionDate" class="form-label">Admission Date</label>
                                    <input type="date" class="form-control" id="admissionDate" name="admission_date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dateOfBirth" name="date_of_birth" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Choose...</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="class" class="form-label">Class</label>
                                    <select class="form-select" id="class" name="class" required>
                                        <option value="">Choose...</option>
                                        <?php
                                        $query = "SELECT * FROM classes";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="section" class="form-label">Section</label>
                                    <select class="form-select" id="section" name="section" required>
                                        <option value="">Choose...</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phoneNumber" name="phone_number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="parentName" class="form-label">Parent/Guardian Name</label>
                                <input type="text" class="form-control" id="parentName" name="parent_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register Student</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/admin-dashboard.js"></script>
    <script>
        function showSection(sectionName) {
            // Hide all sections
            document.getElementById('dashboard-section').style.display = 'none';
            document.getElementById('teachers-section').style.display = 'none';
            document.getElementById('student-registration-section').style.display = 'none';

            // Show selected section
            if (sectionName === 'teachers') {
                document.getElementById('teachers-section').style.display = 'block';
            } else if (sectionName === 'dashboard') {
                document.getElementById('dashboard-section').style.display = 'block';
            } else if (sectionName === 'students') {
                document.getElementById('student-registration-section').style.display = 'block';
            }
        }

        // Initialize DataTables
        $(document).ready(function() {
            $('#teachersTable').DataTable();
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
    </script>
</body>

</html>