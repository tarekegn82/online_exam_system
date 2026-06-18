```php
<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'student')
{
    die("Access denied.");
}

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM exams
     WHERE status='published'
     ORDER BY id DESC"
);

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="page-title mb-1">
                Available Exams
            </h2>

            <p class="text-muted">
                Select an exam and begin your assessment.
            </p>

        </div>

    </div>

    <?php if(mysqli_num_rows($result) > 0) { ?>

    <div class="row">

        <?php while($exam = mysqli_fetch_assoc($result)) { ?>

        <div class="col-md-6 col-lg-4 mb-4">

            <div class="card exam-card h-100">

                <div class="card-body d-flex flex-column">

                    <div class="mb-3">

                        <span class="badge bg-primary">
                            Published
                        </span>

                    </div>

                    <h4 class="exam-title">

                        <?php
                        echo htmlspecialchars(
                            $exam['title']
                        );
                        ?>

                    </h4>

                    <p class="text-muted flex-grow-1">

                        <?php

                        if(!empty($exam['description']))
                        {
                            echo htmlspecialchars(
                                $exam['description']
                            );
                        }
                        else
                        {
                            echo "No description available.";
                        }

                        ?>

                    </p>

                    <hr>

                    <div class="mb-3">

                        <strong>
                            Duration:
                        </strong>

                        <?php
                        echo $exam['duration'];
                        ?>

                        Minutes

                    </div>

                    <a
                    href="take_exam.php?exam_id=<?php echo $exam['id']; ?>"
                    class="btn btn-primary w-100">

                        Start Exam

                    </a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <div class="alert alert-info">

        No published exams are available at the moment.

    </div>

    <?php } ?>

</div>

<?php
require_once dirname(__DIR__) . '/includes/footer.php';
?>
```
