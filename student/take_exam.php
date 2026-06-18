<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

$exam_id = (int)$_GET['exam_id'];

$student_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Check Retake
|--------------------------------------------------------------------------
*/

$check = mysqli_query(
    $conn,
    "SELECT id
     FROM exam_attempts
     WHERE exam_id='$exam_id'
     AND student_id='$student_id'"
);

if(mysqli_num_rows($check) > 0)
{
    die("
    <div class='alert alert-danger m-4'>
        You have already taken this exam.
    </div>
    ");
}

/*
|--------------------------------------------------------------------------
| Get Exam Details
|--------------------------------------------------------------------------
*/

$exam = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT *
         FROM exams
         WHERE id='$exam_id'"
    )
);

if(!$exam)
{
    die("Exam not found.");
}

$duration = (int)$exam['duration'];

/*
|--------------------------------------------------------------------------
| Submit Exam
|--------------------------------------------------------------------------
*/

if(isset($_POST['submit_exam']))
{
    $score = 0;
    $total_marks = 0;

    $attempt_sql = mysqli_prepare(
        $conn,
        "INSERT INTO exam_attempts
        (exam_id,student_id)
        VALUES(?,?)"
    );

    mysqli_stmt_bind_param(
        $attempt_sql,
        "ii",
        $exam_id,
        $student_id
    );

    mysqli_stmt_execute($attempt_sql);

    $attempt_id = mysqli_insert_id($conn);

    $questions = mysqli_query(
        $conn,
        "SELECT *
         FROM questions
         WHERE exam_id='$exam_id'"
    );

    while($q = mysqli_fetch_assoc($questions))
    {
        $question_id = $q['id'];
        $marks = $q['marks'];

        $total_marks += $marks;

        if(isset($_POST['answer'][$question_id]))
        {
            $selected_option =
                $_POST['answer'][$question_id];

            $save = mysqli_prepare(
                $conn,
                "INSERT INTO answers
                (attempt_id,question_id,selected_option_id)
                VALUES(?,?,?)"
            );

            mysqli_stmt_bind_param(
                $save,
                "iii",
                $attempt_id,
                $question_id,
                $selected_option
            );

            mysqli_stmt_execute($save);

            $correct = mysqli_query(
                $conn,
                "SELECT *
                 FROM options
                 WHERE id='$selected_option'
                 AND is_correct=1"
            );

            if(mysqli_num_rows($correct) > 0)
            {
                $score += $marks;
            }
        }
    }

    mysqli_query(
        $conn,
        "UPDATE exam_attempts
         SET score='$score',
             total_marks='$total_marks'
         WHERE id='$attempt_id'"
    );

    header(
        "Location: result.php?attempt_id=$attempt_id"
    );

    exit();
}

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>
            <?php echo htmlspecialchars($exam['title']); ?>
        </h2>

        <p class="text-muted">

            <?php echo htmlspecialchars($exam['description']); ?>

        </p>

    </div>

    <div>

        <div
        id="timer"
        class="badge bg-success p-3 fs-5">

            Loading...

        </div>

    </div>

</div>

<form
method="POST"
id="examForm">

<?php

$questions = mysqli_query(
    $conn,
    "SELECT *
     FROM questions
     WHERE exam_id='$exam_id'"
);

$number = 1;

while($q = mysqli_fetch_assoc($questions))
{
?>

<div class="card mb-4">

    <div class="card-body">

        <h5>

            Question <?php echo $number++; ?>

        </h5>

        <p>

            <strong>

                <?php
                echo htmlspecialchars(
                    $q['question_text']
                );
                ?>

            </strong>

        </p>

        <?php

        $options = mysqli_query(
            $conn,
            "SELECT *
             FROM options
             WHERE question_id='".$q['id']."'"
        );

        while($opt = mysqli_fetch_assoc($options))
        {

        ?>

        <div class="form-check mb-2">

            <input
            class="form-check-input"
            type="radio"
            name="answer[<?php echo $q['id']; ?>]"
            value="<?php echo $opt['id']; ?>"
            required>

            <label
            class="form-check-label">

                <?php
                echo htmlspecialchars(
                    $opt['option_text']
                );
                ?>

            </label>

        </div>

        <?php } ?>

    </div>

</div>

<?php } ?>

<div class="text-center">

<button
type="submit"
name="submit_exam"
class="btn btn-primary btn-lg">

Submit Exam

</button>

</div>

</form>

<script>

let minutes =
<?php echo $duration; ?>;

let totalSeconds =
minutes * 60;

const timer =
document.getElementById("timer");

function updateTimer()
{
    let mins =
    Math.floor(totalSeconds / 60);

    let secs =
    totalSeconds % 60;

    timer.innerHTML =
        mins.toString().padStart(2,'0')
        + ":" +
        secs.toString().padStart(2,'0');

    if(totalSeconds <= 300)
    {
        timer.className =
        "badge bg-danger p-3 fs-5";
    }
    else if(totalSeconds <= 600)
    {
        timer.className =
        "badge bg-warning p-3 fs-5";
    }

    if(totalSeconds <= 0)
    {
        alert(
            "Time is up. Exam will be submitted automatically."
        );

        document
        .getElementById("examForm")
        .submit();
    }

    totalSeconds--;
}

updateTimer();

setInterval(
    updateTimer,
    1000
);

</script>

<?php
require_once dirname(__DIR__) . '/includes/footer.php';
?>