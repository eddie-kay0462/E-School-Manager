<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Registration - Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/parent-registration.css">
</head>

<body class="bg-light">
    <?php
    session_start();
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: var(--primary-green);">
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
                        <a class="nav-link" href="">Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('errorAlert').remove();
                }, 2000);
            </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('successAlert').remove();
                }, 2000);
            </script>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="text-center mb-4">Parent Registration</h1>
                        <form id="parentRegistration" method="POST" action="../actions/register_parent.php">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent ID</label>
                                <input type="text" class="form-control" id="parent_id" name="parent_id" required>
                                <small class="form-text text-muted">Format: PRNT-XXX (e.g., PRNT-001, PRNT-002)</small>
                                <span class="text-danger" id="parentIdError" style="display: none;">Please enter a valid Parent ID</span>
                            </div>

                            <div class="mb-3">
                                <label for="parentName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="parentName" name="parentName" required>
                                <span class="text-danger" id="nameError" style="display: none;">Please enter your name</span>
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
                                <label for="wardId" class="form-label">ID of Ward</label>
                                <input type="text" class="form-control" id="wardId" name="wardId" required>
                                <small class="form-text text-muted">Your ward's student ID (e.g., STU-001)</small>
                                <span class="text-danger" id="wardIdError" style="display: none;">Please enter your ward's ID</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                            <div class="text-center mt-3">
                                <a href="parent-login.php" class="text-decoration-none" style="color: var(--primary-green);">Already have an account? Login here</a>
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
    <script src="../assets/js/parent-registration.js"></script>
</body>

</html>