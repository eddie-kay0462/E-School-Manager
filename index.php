<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Josephus Memorial School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2E7D32;
            --light-green: #4CAF50;
        }

        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2940&q=80');
            height: 50vh;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, transparent 20%, rgba(0, 0, 0, 0.4) 100%);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover {
            background-color: var(--light-green);
            border-color: var(--light-green);
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Josephus Memorial School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                            <li><a class="dropdown-item" href="view/teacher-login.php">Teacher Login</a></li>
                            <li><a class="dropdown-item" href="view/parent-login.php">Parent Login</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="view/school-admin-login.php" class="btn btn-outline-light">I'm a school admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero d-flex align-items-center justify-content-center text-white text-center">
        <div class="container">
            <h1 class="display-4 mb-3">Welcome to Josephus Memorial School </h1>
            <p class="lead">Streamlined Student Management & Academic Progress Tracking</p>
        </div>
    </section>

    <section class="py-5 bg-light mt-n4 position-relative">
        <div class="container">
            <h2 class="text-center mb-4">Access Our School Management System</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm d-flex">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div>
                                <h3 class="card-title text-success mb-3">Teachers</h3>
                                <p class="card-text mb-4">Manage student records, input grades, track attendance, and generate academic reports efficiently.</p>
                            </div>
                            <div class="mt-auto">
                                <a href="./view/teacher-registration.php" class="btn btn-primary">Register as Teacher</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm d-flex">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div>
                                <h3 class="card-title text-success mb-3">Parents</h3>
                                <p class="card-text mb-4">Access your ward's report cards, view academic progress, and stay updated with school activities.</p>
                            </div>
                            <div class="mt-auto">
                                <a href="./view/parent-registration.php" class="btn btn-primary">Register as Parent</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-success text-white text-center py-3 fixed-bottom">
        <p class="mb-0">&copy; 2024 Josephus Memorial School. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>