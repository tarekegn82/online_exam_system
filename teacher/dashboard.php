<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

?>

<h2 class="page-title">
Teacher Dashboard
</h2>

<div class="row">

<div class="col-md-4">

<div class="card">
<div class="card-body">

<h5>Create Exam</h5>

<p>Create a new examination.</p>

<a href="create_exam.php"
class="btn btn-primary">
Open
</a>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card">
<div class="card-body">

<h5>My Exams</h5>

<p>Manage created exams.</p>

<a href="exams.php"
class="btn btn-success">
Open
</a>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card">
<div class="card-body">

<h5>Results</h5>

<p>View student results.</p>

<a href="results.php"
class="btn btn-warning">
Open
</a>

</div>
</div>

</div>

</div>

<div class="mt-4">

<a href="../logout.php"
class="btn btn-danger">
Logout
</a>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>