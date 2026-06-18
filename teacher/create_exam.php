<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$message = "";

if(isset($_POST['save_exam']))
{
    $teacher_id = $_SESSION['user_id'];

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $duration = (int)$_POST['duration'];

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO exams
        (teacher_id,title,description,duration)
        VALUES(?,?,?,?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "issi",
        $teacher_id,
        $title,
        $description,
        $duration
    );

    if(mysqli_stmt_execute($stmt))
    {
        $message = "Exam created successfully.";
    }
    else
    {
        $message = "Failed to create exam.";
    }
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="card">

```
<div class="card-header">
    <h4 class="mb-0">Create Exam</h4>
</div>

<div class="card-body">

    <?php if(!empty($message)) { ?>

        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">
                Exam Title
            </label>

            <input
                type="text"
                name="title"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea
                name="description"
                class="form-control"
                rows="4"></textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Duration (Minutes)
            </label>

            <input
                type="number"
                name="duration"
                class="form-control"
                min="1"
                required>

        </div>

        <button
            type="submit"
            name="save_exam"
            class="btn btn-primary">

            Create Exam

        </button>

        <a
            href="exams.php"
            class="btn btn-secondary">

            Back

        </a>

    </form>

</div>
```

</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
