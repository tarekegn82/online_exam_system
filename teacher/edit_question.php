<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$question_id = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

/*
|--------------------------------------------------------------------------
| Load Question
|--------------------------------------------------------------------------
*/

$q = mysqli_query(
    $conn,
    "SELECT *
     FROM questions
     WHERE id='$question_id'
     LIMIT 1"
);

if(mysqli_num_rows($q) == 0)
{
    die("Question not found.");
}

$question = mysqli_fetch_assoc($q);

/*
|--------------------------------------------------------------------------
| Load Options
|--------------------------------------------------------------------------
*/

$options = [];

$opt_query = mysqli_query(
    $conn,
    "SELECT *
     FROM options
     WHERE question_id='$question_id'
     ORDER BY id ASC"
);

while($row = mysqli_fetch_assoc($opt_query))
{
    $options[] = $row;
}

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

$message = '';

if(isset($_POST['save_question']))
{
    $question_text =
        trim($_POST['question_text']);

    $marks =
        (int)$_POST['marks'];

    mysqli_query(
        $conn,
        "UPDATE questions
         SET
            question_text='".mysqli_real_escape_string($conn,$question_text)."',
            marks='$marks'
         WHERE id='$question_id'"
    );

    $correct =
        (int)$_POST['correct_option'];

    for($i=0; $i<4; $i++)
    {
        $option_text =
            trim($_POST['option'][$i]);

        $option_id =
            $options[$i]['id'];

        $is_correct =
            ($correct == $i)
            ? 1
            : 0;

        mysqli_query(
            $conn,
            "UPDATE options
             SET
                option_text='".mysqli_real_escape_string($conn,$option_text)."',
                is_correct='$is_correct'
             WHERE id='$option_id'"
        );
    }

    $message =
        "Question updated successfully.";

    header(
        "Refresh:1; url=questions.php?exam_id=".$question['exam_id']
    );
}

require_once dirname(__DIR__) . '/includes/header.php';

?>

<h2 class="page-title">
Edit Question
</h2>

<?php if($message != '') { ?>

<div class="alert alert-success">

    <?php echo $message; ?>

</div>

<?php } ?>

<div class="card">

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">

Question

</label>

<textarea
name="question_text"
class="form-control"
rows="3"
required><?php echo htmlspecialchars($question['question_text']); ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Marks

</label>

<input
type="number"
name="marks"
value="<?php echo $question['marks']; ?>"
class="form-control"
required>

</div>

<?php

$correct_index = 0;

foreach($options as $index => $option)
{
    if($option['is_correct'])
    {
        $correct_index = $index;
    }

?>

<div class="mb-3">

<label class="form-label">

Option <?php echo $index + 1; ?>

</label>

<input
type="text"
name="option[]"
value="<?php echo htmlspecialchars($option['option_text']); ?>"
class="form-control"
required>

</div>

<?php } ?>

<div class="mb-3">

<label class="form-label">

Correct Answer

</label>

<select
name="correct_option"
class="form-select">

<option value="0"
<?php if($correct_index == 0) echo 'selected'; ?>>
Option 1
</option>

<option value="1"
<?php if($correct_index == 1) echo 'selected'; ?>>
Option 2
</option>

<option value="2"
<?php if($correct_index == 2) echo 'selected'; ?>>
Option 3
</option>

<option value="3"
<?php if($correct_index == 3) echo 'selected'; ?>>
Option 4
</option>

</select>

</div>

<button
type="submit"
name="save_question"
class="btn btn-primary">

Save Changes

</button>

<a
href="questions.php?exam_id=<?php echo $question['exam_id']; ?>"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>