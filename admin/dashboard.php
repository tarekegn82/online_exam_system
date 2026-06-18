<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

$students = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='student'"
    )
)['total'];

$teachers = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='teacher'"
    )
)['total'];

$exams = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM exams"
    )
)['total'];

$attempts = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM exam_attempts"
    )
)['total'];

?>

<h2 class="page-title">
Admin Dashboard
</h2>

<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="card">

<div class="card-body text-center">

<h1><?php echo $students; ?></h1>

<p>Students</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body text-center">

<h1><?php echo $teachers; ?></h1>

<p>Teachers</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body text-center">

<h1><?php echo $exams; ?></h1>

<p>Exams</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body text-center">

<h1><?php echo $attempts; ?></h1>

<p>Attempts</p>

</div>

</div>

</div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>