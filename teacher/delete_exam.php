<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$teacher_id = $_SESSION['user_id'];

$exam_id =
    isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

/*
|--------------------------------------------------------------------------
| Verify Ownership
|--------------------------------------------------------------------------
*/

$exam = mysqli_query(
    $conn,
    "SELECT id
     FROM exams
     WHERE id='$exam_id'
     AND teacher_id='$teacher_id'"
);

if(mysqli_num_rows($exam) == 0)
{
    die("Exam not found.");
}

/*
|--------------------------------------------------------------------------
| Delete Options
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE o
     FROM options o
     INNER JOIN questions q
        ON o.question_id=q.id
     WHERE q.exam_id='$exam_id'"
);

/*
|--------------------------------------------------------------------------
| Delete Questions
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM questions
     WHERE exam_id='$exam_id'"
);

/*
|--------------------------------------------------------------------------
| Delete Answers
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE a
     FROM answers a
     INNER JOIN exam_attempts ea
        ON a.attempt_id=ea.id
     WHERE ea.exam_id='$exam_id'"
);

/*
|--------------------------------------------------------------------------
| Delete Attempts
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM exam_attempts
     WHERE exam_id='$exam_id'"
);

/*
|--------------------------------------------------------------------------
| Delete Exam
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM exams
     WHERE id='$exam_id'"
);

header("Location: exams.php");
exit();