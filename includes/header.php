<?php

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Online Examination System</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="/online_exam_system/assets/css/style.css"
rel="stylesheet">

<link
href="/online_exam_system/assets/css/style.css"
rel="stylesheet">

</head>

<body>

<?php

if(isset($_SESSION['user_id']))
{
    require_once dirname(__FILE__) . '/sidebar.php';
}

?>

<div class="main-content">