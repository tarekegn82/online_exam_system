<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

$id = (int)$_GET['id'];

mysqli_query(
    $conn,
    "UPDATE exams
     SET status='draft'
     WHERE id='$id'"
);

header("Location: exams.php");
exit();