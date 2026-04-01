<?php
$page = $_GET['endpoint'] ?? 'student';
$projectUrlPrefix = 'api-student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API-STUDENT: Test Interface</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: white;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Menu -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3">
                <h5 class="px-3 mb-4">API Tester</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'student' ? 'active' : ''; ?>" href="index.php?endpoint=student">
                            Student Endpoints
                        </a>
                    </li>
                    <!-- Add more endpoints here -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'health' ? 'active' : ''; ?>" href="index.php?endpoint=health">
                            Health Check
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">

            <div id="testContent">
                <?php
                switch ($page) {
                    case 'student':
                        include 'student.php';
                        break;
                    case 'health':
                        echo '<div class="alert alert-info">Health check test page coming soon...</div>';
                        break;
                    default:
                        echo '<div class="alert alert-danger">Endpoint test page not found.</div>';
                        break;
                }
                ?>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
