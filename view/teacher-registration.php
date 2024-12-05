<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/teacher-registration.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Josephus Memorial School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html">Home</a>
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="text-primary text-center mb-4">Teacher Registration</h1>
                        <form id="teacherRegistration" method="POST" action="../actions/register_teacher.php">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                                <span class="text-danger" id="firstNameError" style="display: none;">Please enter your first name</span>
                            </div>

                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                                <span class="text-danger" id="lastNameError" style="display: none;">Please enter your last name</span>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <span class="text-danger" id="emailError" style="display: none;">Please enter a valid email address</span>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="text-danger" id="passwordError" style="display: none;">
                                    Password must contain at least:
                                    <br id="minLength">- 8 characters
                                    <br id="uppercase">- One uppercase letter (A-Z)
                                    <br id="lowercase">- One lowercase letter (a-z)
                                    <br id="number">- One number (0-9)
                                    <br id="specialChar">- One special character (@$!%*?&)
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                <span class="text-danger" id="confirmPasswordError" style="display: none;">Passwords do not match</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Courses Taught</label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses" value="math" id="mathCheck">
                                            <label class="form-check-label" for="mathCheck">Mathematics</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses" value="english" id="englishCheck">
                                            <label class="form-check-label" for="englishCheck">English</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses" value="science" id="scienceCheck">
                                            <label class="form-check-label" for="scienceCheck">Integrated Science</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses" value="social" id="socialCheck">
                                            <label class="form-check-label" for="socialCheck">Social Studies</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses" value="french" id="frenchCheck">
                                            <label class="form-check-label" for="frenchCheck">French</label>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger" id="coursesError" style="display: none;">Please select at least one course</span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Are you a Class Teacher?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="isClassTeacher" value="yes" id="classTeacherYes" onchange="toggleClassSelect()">
                                    <label class="form-check-label" for="classTeacherYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="isClassTeacher" value="no" id="classTeacherNo" onchange="toggleClassSelect()">
                                    <label class="form-check-label" for="classTeacherNo">No</label>
                                </div>
                                <span class="text-danger" id="classTeacherError" style="display: none;">Please select whether you are a class teacher</span>
                            </div>

                            <div class="mb-3" id="classSelection" style="display: none;">
                                <label for="class" class="form-label">Select Class</label>
                                <select class="form-select" id="class" name="class">
                                    <option value="jss1">JSS 1</option>
                                    <option value="jss2">JSS 2</option>
                                    <option value="jss3">JSS 3</option>
                                </select>
                                <span class="text-danger" id="classError" style="display: none;">Please select a class</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                            <div class="text-center mt-3">
                                <a href="teacher-login.html" class="text-decoration-none text-primary">Already have an account? Login here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-success text-white text-center py-3 fixed-bottom">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/teacher-registration.js"></script>
</body>

</html>