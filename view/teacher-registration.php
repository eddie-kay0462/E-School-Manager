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
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class=" container">
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="text-primary text-center mb-4">Teacher Registration</h1>
                        <?php
                        session_start();
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($_SESSION['error']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($_SESSION['success']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form id="teacherRegistration" method="POST" action="../actions/register_teacher.php">
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Select Teacher ID</label>
                                <select class="form-select" id="teacher_id" name="teacher_id" required>
                                    <option value="">Choose Teacher ID...</option>
                                    <?php
                                    for ($i = 1; $i <= 25; $i++) {
                                        $id = str_pad($i, 3, '0', STR_PAD_LEFT);
                                        echo "<option value='TEACH-{$id}'>TEACH-{$id}</option>";
                                    }
                                    ?>
                                </select>
                                <span class="text-danger" id="teacherIdError" style="display: none;">Please select a Teacher ID</span>
                            </div>

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
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="math" id="mathCheck">
                                            <label class="form-check-label" for="mathCheck">Mathematics</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="english" id="englishCheck">
                                            <label class="form-check-label" for="englishCheck">English</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="science" id="scienceCheck">
                                            <label class="form-check-label" for="scienceCheck">Integrated Science</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="social" id="socialCheck">
                                            <label class="form-check-label" for="socialCheck">Social Studies</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="french" id="frenchCheck">
                                            <label class="form-check-label" for="frenchCheck">French</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="computing" id="computingCheck">
                                            <label class="form-check-label" for="computingCheck">Computing</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="ga" id="gaCheck">
                                            <label class="form-check-label" for="gaCheck">GA</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="rme" id="rmeCheck">
                                            <label class="form-check-label" for="rmeCheck">RME</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="econs" id="homeecCheck">
                                            <label class="form-check-label" for="homeecCheck">Home Economics</label>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger" id="coursesError" style="display: none;">Please select at least one course</span>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="isClassTeacher" value="yes" id="classTeacherCheck" onchange="toggleClassSelect()">
                                    <label class="form-check-label" for="classTeacherCheck">I am a Class Teacher</label>
                                </div>
                            </div>

                            <div class="mb-3" id="classSelection" style="display: none;">
                                <label class="form-label">Select Class</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="class" value="jss1" id="jss1">
                                    <label class="form-check-label" for="jss1">JSS 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="class" value="jss2" id="jss2">
                                    <label class="form-check-label" for="jss2">JSS 2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="class" value="jss3" id="jss3">
                                    <label class="form-check-label" for="jss3">JSS 3</label>
                                </div>
                                <span class="text-danger" id="classError" style="display: none;">Please select a class</span>
                            </div>

                            <div class="mb-3" id="teachingClasses">
                                <label class="form-label">Classes You Teach</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="teaching_classes[]" value="jss1" id="teachJss1">
                                    <label class="form-check-label" for="teachJss1">JSS 1</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="teaching_classes[]" value="jss2" id="teachJss2">
                                    <label class="form-check-label" for="teachJss2">JSS 2</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="teaching_classes[]" value="jss3" id="teachJss3">
                                    <label class="form-check-label" for="teachJss3">JSS 3</label>
                                </div>
                                <span class="text-danger" id="teachingClassesError" style="display: none;">Please select at least one class</span>
                            </div>


                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                            <div class="text-center mt-3">
                                <a href="teacher-login.php" class="text-decoration-none text-primary">Already have an account? Login here</a>
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