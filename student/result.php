<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'student')
{
    die("Access denied.");
}

$student_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT
        ea.id,
        ea.score,
        ea.total_marks,
        ea.submitted_at,
        e.title
     FROM exam_attempts ea
     INNER JOIN exams e
        ON ea.exam_id = e.id
     WHERE ea.student_id='$student_id'
     ORDER BY ea.id DESC"
);

?>

<h2 class="page-title">
My Results
</h2>

<div class="card">

    <div class="card-header">

        Complete Examination History

    </div>

    <div class="card-body">

        <?php if(mysqli_num_rows($result) > 0) { ?>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

            <tr>

                <th>#</th>

                <th>Exam</th>

                <th>Score</th>

                <th>Percentage</th>

                <th>Status</th>

                <th>Date</th>

            </tr>

            </thead>

            <tbody>

            <?php

            $count = 1;

            while($row = mysqli_fetch_assoc($result))
            {

                $percentage = 0;

                if($row['total_marks'] > 0)
                {
                    $percentage = round(
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
                    <?php echo htmlspecialchars($row['title']); ?>
                </td>

                <td>

                    <?php echo $row['score']; ?>

                    /

                    <?php echo $row['total_marks']; ?>

                </td>

                <td>

                    <?php echo $percentage; ?>%

                </td>

                <td>

                    <?php

                    if($percentage >= 50)
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

        <?php } else { ?>

        <div class="alert alert-info">

            You have not taken any exams yet.

        </div>

        <?php } ?>

    </div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>