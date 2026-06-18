<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$question_id =
    isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

$exam_id =
    isset($_GET['exam_id'])
    ? (int)$_GET['exam_id']
    : 0;

/*
|--------------------------------------------------------------------------
| Delete Options First
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM options
     WHERE question_id='$question_id'"
);

/*
|--------------------------------------------------------------------------
| Delete Question
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM questions
     WHERE id='$question_id'"
);

header(
    "Location: questions.php?exam_id=$exam_id"
);

exit();