<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;

$exam_query = mysqli_query(
    $conn,
    "SELECT * FROM exams WHERE id='$exam_id' LIMIT 1"
);

if(mysqli_num_rows($exam_query) == 0)
{
    die("Exam not found.");
}

$exam = mysqli_fetch_assoc($exam_query);

$message = "";

if(isset($_POST['add_question']))
{
    $question = trim($_POST['question']);
    $marks = (int)$_POST['marks'];

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO questions
        (exam_id,question_text,marks)
        VALUES(?,?,?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isi",
        $exam_id,
        $question,
        $marks
    );

    mysqli_stmt_execute($stmt);

    $question_id = mysqli_insert_id($conn);

    for($i=1;$i<=4;$i++)
    {
        $option_text = trim($_POST['option'.$i]);

        $is_correct =
            ($_POST['correct_option'] == $i) ? 1 : 0;

        $stmt2 = mysqli_prepare(
            $conn,
            "INSERT INTO options
            (question_id,option_text,is_correct)
            VALUES(?,?,?)"
        );

        mysqli_stmt_bind_param(
            $stmt2,
            "isi",
            $question_id,
            $option_text,
            $is_correct
        );

        mysqli_stmt_execute($stmt2);
    }

    $message = "Question added successfully.";
}

require_once dirname(__DIR__) . '/includes/header.php';

$count_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM questions
     WHERE exam_id='$exam_id'"
);

$count_data = mysqli_fetch_assoc($count_result);

$total_questions = $count_data['total'];

?>

<div class="card mb-4">

```
<div class="card-header d-flex justify-content-between align-items-center">

    <div>

        <h4 class="mb-0">
            Manage Questions
        </h4>

        <small class="text-muted">
            Exam: <?php echo htmlspecialchars($exam['title']); ?>
        </small>

    </div>

    <span class="badge bg-primary">
        Total Questions:
        <?php echo $total_questions; ?>
    </span>

</div>
```

</div>

<?php if(!empty($message)) { ?>

<div class="alert alert-success">
    <?php echo $message; ?>
</div>

<?php } ?>

<div class="card mb-4">

```
<div class="card-header">
    Add New Question
</div>

<div class="card-body">

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Question
            </label>

            <textarea
                name="question"
                class="form-control"
                rows="3"
                required></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Marks
            </label>

            <input
                type="number"
                name="marks"
                value="1"
                min="1"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Option 1
            </label>

            <input
                type="text"
                name="option1"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Option 2
            </label>

            <input
                type="text"
                name="option2"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Option 3
            </label>

            <input
                type="text"
                name="option3"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Option 4
            </label>

            <input
                type="text"
                name="option4"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Correct Answer
            </label>

            <select
                name="correct_option"
                class="form-select">

                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>

            </select>

        </div>

        <button
            type="submit"
            name="add_question"
            class="btn btn-primary">

            Add Question

        </button>

    </form>

</div>
```

</div>

<?php

$questions = mysqli_query(
    $conn,
    "SELECT *
     FROM questions
     WHERE exam_id='$exam_id'
     ORDER BY id DESC"
);

while($q = mysqli_fetch_assoc($questions))
{

?>

<div class="card mb-3">

```
<div class="mt-3">

<a
href="edit_question.php?id=<?php echo $q['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete_question.php?id=<?php echo $q['id']; ?>&exam_id=<?php echo $exam_id; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this question?');">

Delete

</a>

</div>

<div class="card-body">

    <ul class="list-group">

    <?php

    $question_id = $q['id'];

    $options = mysqli_query(
        $conn,
        "SELECT *
         FROM options
         WHERE question_id='$question_id'"
    );

    while($opt = mysqli_fetch_assoc($options))
    {

        if($opt['is_correct'])
        {
            echo '<li class="list-group-item list-group-item-success">';
            echo '✓ ' . htmlspecialchars($opt['option_text']);
            echo '</li>';
        }
        else
        {
            echo '<li class="list-group-item">';
            echo htmlspecialchars($opt['option_text']);
            echo '</li>';
        }

    }

    ?>

    </ul>

    <div class="mt-3">

        <span class="badge bg-info">
            Marks:
            <?php echo $q['marks']; ?>
        </span>

    </div>

</div>
```

</div>

<?php } ?>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
