<?php

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

$role = $_SESSION['role'] ?? '';

?>

<div class="sidebar">

    <div class="sidebar-header">

        <h4>Online Exam</h4>

        <small>
            <?php echo htmlspecialchars($_SESSION['fullname']); ?>
        </small>

    </div>

    <ul class="sidebar-menu">

        <?php if($role == 'admin') { ?>

            <li>
                <a href="/online_exam_system/admin/dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/online_exam_system/admin/users.php">
                    Users
                </a>
            </li>

        <?php } ?>

        <?php if($role == 'teacher') { ?>

            <li>
                <a href="/online_exam_system/teacher/dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/online_exam_system/teacher/create_exam.php">
                    Create Exam
                </a>
            </li>

            <li>
                <a href="/online_exam_system/teacher/exams.php">
                    My Exams
                </a>
            </li>

            <li>
                <a href="/online_exam_system/teacher/results.php">
                    Results
                </a>
            </li>

        <?php } ?>

        <?php if($role == 'student') { ?>

            <li>
                <a href="/online_exam_system/student/dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/online_exam_system/student/exams.php">
                    Available Exams
                </a>
            </li>

            <li>
                <a href="/online_exam_system/student/result.php">
                    My Results
                </a>
            </li>

        <?php } ?>

        <li>

            <a href="/online_exam_system/logout.php">

                Logout

            </a>

        </li>

    </ul>

</div>