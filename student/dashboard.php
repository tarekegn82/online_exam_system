<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'student')
{
    die("Access denied.");
}

$student_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$exams_taken = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM exam_attempts
         WHERE student_id='$student_id'"
    )
)['total'];

$available_exams = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM exams
         WHERE status='published'"
    )
)['total'];

$avg_result = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT
            AVG(
                (score / total_marks) * 100
            ) avg_score
         FROM exam_attempts
         WHERE student_id='$student_id'
         AND total_marks > 0"
    )
);

$average_score =
    round($avg_result['avg_score'] ?? 0, 2);

?>

<h2 class="page-title">
Student Dashboard
</h2>

<p class="text-muted">
Welcome,
<?php echo htmlspecialchars($_SESSION['fullname']); ?>
</p>

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h1>
                    <?php echo $exams_taken; ?>
                </h1>

                <p class="mb-0">
                    Exams Taken
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

                <p class="mb-0">
                    Average Score
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                <h1>
                    <?php echo $available_exams; ?>
                </h1>

                <p class="mb-0">
                    Available Exams
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="card mb-4">

            <div class="card-header">
                Available Exams
            </div>

            <div class="card-body">

                <?php

                $exams = mysqli_query(
                    $conn,
                    "SELECT *
                     FROM exams
                     WHERE status='published'
                     ORDER BY id DESC
                     LIMIT 5"
                );

                if(mysqli_num_rows($exams) > 0)
                {

                    echo "<ul class='list-group'>";

                    while($exam = mysqli_fetch_assoc($exams))
                    {

                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";

                        echo htmlspecialchars($exam['title']);

                        echo "<a href='exams.php' class='btn btn-sm btn-primary'>Open</a>";

                        echo "</li>";
                    }

                    echo "</ul>";

                }
                else
                {
                    echo "<p>No published exams available.</p>";
                }

                ?>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card mb-4">

            <div class="card-header">
                Recent Results
            </div>

            <div class="card-body">

                <?php

                $results = mysqli_query(
                    $conn,
                    "SELECT
                        e.title,
                        ea.score,
                        ea.total_marks
                     FROM exam_attempts ea
                     INNER JOIN exams e
                        ON ea.exam_id=e.id
                     WHERE ea.student_id='$student_id'
                     ORDER BY ea.id DESC
                     LIMIT 5"
                );

                if(mysqli_num_rows($results) > 0)
                {

                    echo "<ul class='list-group'>";

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

                        echo "<li class='list-group-item'>";

                        echo "<strong>";

                        echo htmlspecialchars(
                            $row['title']
                        );

                        echo "</strong><br>";

                        echo "Score: ";

                        echo $row['score'];

                        echo "/";

                        echo $row['total_marks'];

                        echo " (";

                        echo $percent;

                        echo "%)";

                        echo "</li>";
                    }

                    echo "</ul>";

                }
                else
                {
                    echo "<p>No exam history available.</p>";
                }

                ?>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-body text-center">

        <h4>
            Ready for your next exam?
        </h4>

        <a
            href="exams.php"
            class="btn btn-success btn-lg">

            View Available Exams

        </a>

    </div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>