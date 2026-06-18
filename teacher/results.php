<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$teacher_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Analytics
|--------------------------------------------------------------------------
*/

$attempts_query = mysqli_query(
    $conn,
    "SELECT
        ea.score,
        ea.total_marks
     FROM exam_attempts ea
     INNER JOIN exams e
        ON ea.exam_id=e.id
     WHERE e.teacher_id='$teacher_id'"
);

$total_attempts = 0;
$total_percentage = 0;
$total_pass = 0;

while($row = mysqli_fetch_assoc($attempts_query))
{
    $total_attempts++;

    if($row['total_marks'] > 0)
    {
        $percent =
            ($row['score'] /
            $row['total_marks']) * 100;

        $total_percentage += $percent;

        if($percent >= 50)
        {
            $total_pass++;
        }
    }
}

$average_score =
    ($total_attempts > 0)
    ? round($total_percentage / $total_attempts, 2)
    : 0;

$pass_rate =
    ($total_attempts > 0)
    ? round(($total_pass / $total_attempts) * 100, 2)
    : 0;

?>

<h2 class="page-title">
Student Results Analytics
</h2>

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h1>
                    <?php echo $total_attempts; ?>
                </h1>

                <p>
                    Total Attempts
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h1>
                    <?php echo $average_score; ?>%
                </h1>

                <p>
                    Average Score
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h1>
                    <?php echo $pass_rate; ?>%
                </h1>

                <p>
                    Pass Rate
                </p>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">

        All Student Results

    </div>

    <div class="card-body">

        <table
        class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Student</th>

                    <th>Exam</th>

                    <th>Score</th>

                    <th>%</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $results = mysqli_query(
                $conn,
                "SELECT
                    ea.*,
                    u.fullname,
                    e.title
                 FROM exam_attempts ea

                 INNER JOIN users u
                    ON ea.student_id=u.id

                 INNER JOIN exams e
                    ON ea.exam_id=e.id

                 WHERE e.teacher_id='$teacher_id'

                 ORDER BY ea.id DESC"
            );

            $count = 1;

            while($row = mysqli_fetch_assoc($results))
            {
                $percent = 0;

                if($row['total_marks'] > 0)
                {
                    $percent = round(
                        ($row['score'] /
                        $row['total_marks']) * 100,
                        2
                    );
                }

            ?>

            <tr>

                <td>
                    <?php echo $count++; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['fullname']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['title']); ?>
                </td>

                <td>

                    <?php echo $row['score']; ?>

                    /

                    <?php echo $row['total_marks']; ?>

                </td>

                <td>

                    <?php echo $percent; ?>%

                </td>

                <td>

                    <?php

                    if($percent >= 50)
                    {
                        echo '<span class="badge bg-success">PASS</span>';
                    }
                    else
                    {
                        echo '<span class="badge bg-danger">FAIL</span>';
                    }

                    ?>

                </td>

                <td>

                    <?php echo $row['submitted_at']; ?>

                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>