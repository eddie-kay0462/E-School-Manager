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

        .grade-input {
            width: 60px;
            text-align: center;
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
                        <h1>Welcome, Mr. Smith</h1>
                        <p class="mb-0">Subject Teacher - Mathematics</p>
                    </div>
                </div>

                <div class="card mb-4 d-none" id="courseRecords">
                    <div class="card-body">
                        <h2 id="courseTitle"></h2>
                        <p class="mb-0" id="courseMessage"></p>
                    </div>
                </div>

                <div id="grades" class="tab-content card active">
                    <div class="card-body">
                        <h2>Student Grades</h2>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Assignment</th>
                                        <th>Classwork</th>
                                        <th>Homework</th>
                                        <th>Midterm</th>
                                        <th>Final</th>
                                        <th>Overall</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td><input type="number" class="form-control grade-input" value="85" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="90" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="88" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="92" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="95" min="0" max="100"></td>
                                        <td>90</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button></td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td><input type="number" class="form-control grade-input" value="92" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="88" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="95" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="90" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="93" min="0" max="100"></td>
                                        <td>92</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button></td>
                                    </tr>
                                    <tr>
                                        <td>Michael Johnson</td>
                                        <td><input type="number" class="form-control grade-input" value="88" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="85" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="90" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="87" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="89" min="0" max="100"></td>
                                        <td>88</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button></td>
                                    </tr>
                                    <tr>
                                        <td>Sarah Williams</td>
                                        <td><input type="number" class="form-control grade-input" value="95" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="92" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="93" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="94" min="0" max="100"></td>
                                        <td><input type="number" class="form-control grade-input" value="96" min="0" max="100"></td>
                                        <td>94</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="saveGrades(this)">Save</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Class Performance</h3>
                                        <p>Class Average: 89.5%</p>
                                        <p>Highest Score: 96%</p>
                                        <p class="mb-0">Lowest Score: 82%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-primary btn-lg" onclick="finalizeGrades()">
                                <i class="fas fa-check-circle me-2"></i>Finalize and Submit All Grades
                            </button>
                        </div>
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
        function showCourseRecords(courseName) {
            const courseRecords = document.getElementById('courseRecords');
            const courseTitle = document.getElementById('courseTitle');
            const courseMessage = document.getElementById('courseMessage');

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

        function finalizeGrades() {
            if (confirm('Are you sure you want to finalize and submit all grades? This action cannot be undone.')) {
                // Here you would typically send the data to your backend
                alert('Grades have been finalized and submitted successfully!');

                // Disable all inputs and save buttons
                document.querySelectorAll('.grade-input').forEach(input => {
                    input.disabled = true;
                });
                document.querySelectorAll('button[onclick="saveGrades(this)"]').forEach(button => {
                    button.disabled = true;
                });
            }
        }
    </script>
</body>

</html>