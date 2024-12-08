<!DOCTYPE html>
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

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .student-attendance {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .grade-input {
            width: 60px;
            text-align: center;
        }

        .edit-btn {
            padding: 2px 8px;
            margin-right: 5px;
            font-size: 12px;
        }

        .course-data {
            display: none;
        }

        .course-data.active {
            display: block;
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
                    <div class="course-item" onclick="showCourseRecords('Mathematics')">
                        <i class="fas fa-square-root-alt"></i>
                        <span>Mathematics</span>
                    </div>
                    <div class="course-item" onclick="showCourseRecords('English')">
                        <i class="fas fa-book"></i>
                        <span>English</span>
                    </div>
                    <div class="course-item" onclick="showCourseRecords('Integrated Science')">
                        <i class="fas fa-flask"></i>
                        <span>Integrated Science</span>
                    </div>
                    <div class="course-item" onclick="showCourseRecords('Social Studies')">
                        <i class="fas fa-globe"></i>
                        <span>Social Studies</span>
                    </div>
                    <div class="course-item" onclick="showCourseRecords('French')">
                        <i class="fas fa-language"></i>
                        <span>French</span>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 p-4 bg-light">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1>Welcome, Mrs. Johnson</h1>
                                <p class="mb-0">Class Teacher - JSS 2</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 d-none" id="courseRecords">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 id="courseTitle"></h2>
                                <p class="mb-0" id="courseMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary me-2" onclick="showTab('attendance')">Manage Attendance</button>
                    <button class="btn btn-primary me-2" onclick="showTab('grades')">Manage Grades</button>
                    <button class="btn btn-primary" onclick="showTab('registerStudent')">Register Student</button>
                </div>

                <div id="attendance" class="tab-content card">
                    <div class="card-body">
                        <!-- Mathematics Attendance -->
                        <div id="Mathematics-attendance" class="course-data">
                            <h2>Mathematics Attendance</h2>
                            <div class="student-attendance d-flex justify-content-between align-items-center">
                                <span>John Smith</span>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="math_attendance_1" id="math_present_1" value="present">
                                    <label class="btn btn-outline-success" for="math_present_1">Present</label>
                                    <input type="radio" class="btn-check" name="math_attendance_1" id="math_absent_1" value="absent">
                                    <label class="btn btn-outline-danger" for="math_absent_1">Absent</label>
                                </div>
                            </div>
                        </div>

                        <!-- English Attendance -->
                        <div id="English-attendance" class="course-data">
                            <h2>English Attendance</h2>
                            <div class="student-attendance d-flex justify-content-between align-items-center">
                                <span>Emma Wilson</span>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="eng_attendance_1" id="eng_present_1" value="present">
                                    <label class="btn btn-outline-success" for="eng_present_1">Present</label>
                                    <input type="radio" class="btn-check" name="eng_attendance_1" id="eng_absent_1" value="absent">
                                    <label class="btn btn-outline-danger" for="eng_absent_1">Absent</label>
                                </div>
                            </div>
                        </div>

                        <!-- Science Attendance -->
                        <div id="Integrated Science-attendance" class="course-data">
                            <h2>Science Attendance</h2>
                            <div class="student-attendance d-flex justify-content-between align-items-center">
                                <span>David Brown</span>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="sci_attendance_1" id="sci_present_1" value="present">
                                    <label class="btn btn-outline-success" for="sci_present_1">Present</label>
                                    <input type="radio" class="btn-check" name="sci_attendance_1" id="sci_absent_1" value="absent">
                                    <label class="btn btn-outline-danger" for="sci_absent_1">Absent</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="grades" class="tab-content card">
                    <div class="card-body">
                        <!-- Mathematics Grades -->
                        <div id="Mathematics-grades" class="course-data">
                            <h2>Mathematics Grades</h2>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Classwork (10%)</th>
                                            <th>Homework (10%)</th>
                                            <th>Midterm Exam (10%)</th>
                                            <th>Final Exam (10%)</th>
                                            <th>Overall (100%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>MATH001</td>
                                            <td>John Smith</td>
                                            <td><input type="number" class="form-control grade-input" value="85"></td>
                                            <td><input type="number" class="form-control grade-input" value="78"></td>
                                            <td><input type="number" class="form-control grade-input" value="82"></td>
                                            <td><input type="number" class="form-control grade-input" value="92"></td>
                                            <td>85</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteGrades(this)">Delete</button>
                                                <button class="btn btn-warning btn-sm" onclick="updateGrades(this)">Update</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- English Grades -->
                        <div id="English-grades" class="course-data">
                            <h2>English Grades</h2>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Classwork (10%)</th>
                                            <th>Homework (10%)</th>
                                            <th>Midterm Exam (10%)</th>
                                            <th>Final Exam (10%)</th>
                                            <th>Overall (100%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ENG001</td>
                                            <td>Emma Wilson</td>
                                            <td><input type="number" class="form-control grade-input" value="92"></td>
                                            <td><input type="number" class="form-control grade-input" value="88"></td>
                                            <td><input type="number" class="form-control grade-input" value="85"></td>
                                            <td><input type="number" class="form-control grade-input" value="90"></td>
                                            <td>90</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteGrades(this)">Delete</button>
                                                <button class="btn btn-warning btn-sm" onclick="updateGrades(this)">Update</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Science Grades -->
                        <div id="Integrated Science-grades" class="course-data">
                            <h2>Science Grades</h2>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Classwork (10%)</th>
                                            <th>Homework (10%)</th>
                                            <th>Midterm Exam (10%)</th>
                                            <th>Final Exam (10%)</th>
                                            <th>Overall (100%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SCI001</td>
                                            <td>David Brown</td>
                                            <td><input type="number" class="form-control grade-input" value="95"></td>
                                            <td><input type="number" class="form-control grade-input" value="87"></td>
                                            <td><input type="number" class="form-control grade-input" value="89"></td>
                                            <td><input type="number" class="form-control grade-input" value="91"></td>
                                            <td>91</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteGrades(this)">Delete</button>
                                                <button class="btn btn-warning btn-sm" onclick="updateGrades(this)">Update</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="registerStudent" class="tab-content card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Register New Student</h2>
                        </div>

                        <form id="studentRegistrationForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="studentId" class="form-label">Student ID</label>
                                    <input type="text" class="form-control" id="studentId" name="studentId" required>
                                    <span class="text-danger" id="studentIdError" style="display: none;">Please enter a valid student ID</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                    <span class="text-danger" id="dobError" style="display: none;">Please enter a valid date of birth</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <span class="text-danger" id="genderError" style="display: none;">Please select a gender</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guardianId" class="form-label">Guardian ID</label>
                                    <input type="text" class="form-control" id="guardianId" name="guardianId" required>
                                    <span class="text-danger" id="guardianIdError" style="display: none;">Please enter a valid guardian ID</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="enrollmentDate" class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" id="enrollmentDate" name="enrollmentDate" required>
                                <span class="text-danger" id="enrollmentDateError" style="display: none;">Please enter a valid enrollment date</span>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Register Student
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show default tab
        document.getElementById('attendance').classList.add('active');

        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');
        }

        function showCourseRecords(courseName) {
            const courseRecords = document.getElementById('courseRecords');
            const courseTitle = document.getElementById('courseTitle');
            const courseMessage = document.getElementById('courseMessage');

            // Hide all course-specific data
            document.querySelectorAll('.course-data').forEach(data => {
                data.classList.remove('active');
            });

            // Show course-specific data
            document.getElementById(`${courseName}-attendance`).classList.add('active');
            document.getElementById(`${courseName}-grades`).classList.add('active');

            courseTitle.textContent = courseName;
            courseMessage.textContent = `Viewing records for ${courseName} course`;
            courseRecords.classList.remove('d-none');
        }

        function saveGrades(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input[type="number"]');
            let sum = 0;
            inputs.forEach(input => {
                sum += parseInt(input.value) || 0;
            });
            const average = Math.round(sum / inputs.length);
            row.querySelector('td:nth-last-child(2)').textContent = average;

            // Show save confirmation
            button.textContent = 'Saved!';
            button.disabled = true;
            setTimeout(() => {
                button.textContent = 'Save';
                button.disabled = false;
            }, 2000);
        }

        function deleteGrades(button) {
            if (confirm('Are you sure you want to delete these grades?')) {
                const row = button.closest('tr');
                row.remove();
            }
        }

        function updateGrades(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input[type="number"]');
            
            inputs.forEach(input => {
                input.disabled = false;
            });

            button.textContent = 'Confirm';
            button.onclick = function() {
                inputs.forEach(input => {
                    input.disabled = true;
                });
                saveGrades(button);
                button.textContent = 'Update';
                button.onclick = function() { updateGrades(button); };
            };
        }

        function finalizeGrades() {
            if (confirm('Are you sure you want to finalize and submit all grades? This action cannot be undone.')) {
                const inputs = document.querySelectorAll('.grade-input');
                inputs.forEach(input => input.disabled = true);

                const saveButtons = document.querySelectorAll('button[onclick="saveGrades(this)"]');
                saveButtons.forEach(button => button.disabled = true);

                // Show success message
                alert('All grades have been finalized and submitted successfully!');
            }
        }
    </script>
</body>

</html>