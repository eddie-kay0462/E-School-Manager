<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-registration.css">
    <style>
        :root {
            --primary-green: #198754;
            --light-green: #28a745;
        }

        body {
            background: #f8f9fa;
            padding-bottom: 60px;
        }

        .navbar {
            background-color: var(--primary-green);
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--light-green);
            border-color: var(--light-green);
            transform: scale(1.02);
        }

        .text-primary {
            color: var(--primary-green) !important;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .alert {
            border-radius: 8px;
        }

        .fixed-bottom {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Josephus Memorial School</a>
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
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 text-primary">Admin Registration</h2>
                        <?php
                        session_start();
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($_SESSION['error']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                        <form id="adminRegistrationForm" method="POST" action="../actions/admin_register_backend.php">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                                <div id="firstNameError" class="text-danger" style="display: none;">First name must be at least 2 characters long</div>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                                <div id="lastNameError" class="text-danger" style="display: none;">Last name must be at least 2 characters long</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div id="emailError" class="text-danger" style="display: none;">Please enter a valid email address</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div id="passwordError" class="text-danger">Password must meet the following requirements:</div>
                                <div id="minLength" class="text-danger" style="display: none;">- At least 8 characters long</div>
                                <div id="uppercase" class="text-danger" style="display: none;">- At least one uppercase letter</div>
                                <div id="lowercase" class="text-danger" style="display: none;">- At least one lowercase letter</div>
                                <div id="number" class="text-danger" style="display: none;">- At least one number</div>
                                <div id="specialChar" class="text-danger" style="display: none;">- At least one special character (@$!%*?&)</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                <div id="confirmPasswordError" class="text-danger" style="display: none;">Passwords do not match</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                            <div class="text-center mt-3">
                                <p>Already have an account? <a href="school-admin-login.php" class="text-primary">Login here</a></p>
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
    <script src="../assets/js/school-admin-register.js"></script>
</body>

</html>