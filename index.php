<?php
session_start();

if(isset($_SESSION['role']))
{
    if($_SESSION['role'] == 'admin')
    {
        header("Location: admin/dashboard.php");
        exit();
    }

    if($_SESSION['role'] == 'teacher')
    {
        header("Location: teacher/dashboard.php");
        exit();
    }

    if($_SESSION['role'] == 'student')
    {
        header("Location: student/dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Online Examination System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.hero{
    padding:100px 0;
    background:#0d6efd;
    color:white;
}

.feature-card{
    transition:0.3s;
}

.feature-card:hover{
    transform:translateY(-5px);
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="#">
Online Exam System
</a>

<div>

<a href="login.php" class="btn btn-outline-light me-2">
Login
</a>

<a href="register.php" class="btn btn-primary">
Register
</a>

</div>

</div>

</nav>

<section class="hero">

<div class="container text-center">

<h1 class="display-4 fw-bold">
Online Examination System
</h1>

<p class="lead">

Create exams, manage students,
conduct assessments and generate results instantly.

</p>

<a href="login.php" class="btn btn-light btn-lg me-2">
Login
</a>

<a href="register.php" class="btn btn-warning btn-lg">
Register
</a>

</div>

</section>

<section class="py-5">

<div class="container">

<h2 class="text-center mb-5">
System Features
</h2>

<div class="row">

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<h4>👨‍🏫</h4>

<h5>Teachers</h5>

<p>Create and manage exams.</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<h4>📝</h4>

<h5>Students</h5>

<p>Take exams online.</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<h4>⚡</h4>

<h5>Auto Grading</h5>

<p>Instant result generation.</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<h4>📊</h4>

<h5>Reports</h5>

<p>Track performance easily.</p>

</div>

</div>

</div>

</div>

</div>

</section>

<footer class="bg-dark text-white text-center p-4">

Online Examination System © <?php echo date('Y'); ?>

</footer>

</body>
</html>