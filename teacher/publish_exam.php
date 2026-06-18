<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$id = (int)$_GET['id'];

$check = mysqli_fetch_assoc(

    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM questions
         WHERE exam_id='$id'"
    )

);

if($check['total'] == 0)
{
    die(
        "Cannot publish an exam with no questions."
    );
}

mysqli_query(
    $conn,
    "UPDATE exams
     SET status='published'
     WHERE id='$id'"
);

header("Location: exams.php");
exit();