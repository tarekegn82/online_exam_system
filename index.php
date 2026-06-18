```php
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

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
rel="stylesheet">

<style>

body{
    background:#f8f9fa;
}

.navbar-brand{
    font-weight:700;
}

.hero{
    background:#0d6efd;
    color:#fff;
    padding:100px 0;
}

.hero h1{
    font-weight:700;
}

.feature-card{
    border:none;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-6px);
}

.feature-icon{
    font-size:42px;
    color:#0d6efd;
    margin-bottom:15px;
}

.stats{
    background:#fff;
    padding:60px 0;
}

.stat-box h2{
    font-weight:700;
    color:#0d6efd;
}

footer{
    margin-top:50px;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="#">
Online Examination System
</a>

<div>

<a
href="login.php"
class="btn btn-outline-light me-2">

Login

</a>

<a
href="register.php"
class="btn btn-primary">

Register

</a>

</div>

</div>

</nav>

<section class="hero">

<div class="container text-center">

<h1 class="display-4">

Online Examination System

</h1>

<p class="lead mt-3 mb-4">

A simple platform for creating exams,
conducting assessments, and managing results online.

</p>

<a
href="login.php"
class="btn btn-light btn-lg me-2">

Login

</a>

<a
href="register.php"
class="btn btn-warning btn-lg">

Register

</a>

</div>

</section>

<section class="py-5">

<div class="container">

<h2 class="text-center mb-5">

Platform Features

</h2>

<div class="row g-4">

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<i class="bi bi-person-workspace feature-icon"></i>

<h5>

Teacher Management

</h5>

<p>

Create exams, manage questions,
and monitor student performance.

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<i class="bi bi-journal-check feature-icon"></i>

<h5>

Online Examinations

</h5>

<p>

Students can take examinations
from any device with internet access.

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<i class="bi bi-stopwatch feature-icon"></i>

<h5>

Timed Assessments

</h5>

<p>

Built-in exam timer with
automatic submission.

</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card feature-card h-100">

<div class="card-body text-center">

<i class="bi bi-bar-chart-line feature-icon"></i>

<h5>

Analytics & Reports

</h5>

<p>

Track examination performance
and view detailed results.

</p>

</div>

</div>

</div>

</div>

</div>

</section>

<section class="stats">

<div class="container">

<div class="row text-center">

<div class="col-md-4 stat-box">

<h2>24/7</h2>

<p>System Availability</p>

</div>

<div class="col-md-4 stat-box">

<h2>100%</h2>

<p>Automated Grading</p>

</div>

<div class="col-md-4 stat-box">

<h2>3 Roles</h2>

<p>Admin, Teacher & Student</p>

</div>

</div>

</div>

</section>

<footer class="bg-dark text-white text-center p-4">

<div class="container">

Online Examination System &copy; <?php echo date('Y'); ?>

</div>

</footer>

</body>

</html>
```
