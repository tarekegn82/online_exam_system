<?php

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/header.php';

if($_SESSION['role'] != 'teacher')
{
    die("Access denied.");
}

$teacher_id = $_SESSION['user_id'];

$search = '';

if(isset($_GET['search']))
{
    $search = mysqli_real_escape_string(
        $conn,
        trim($_GET['search'])
    );
}

$sql = "
SELECT *
FROM exams
WHERE teacher_id='$teacher_id'
";

if($search != '')
{
    $sql .= "
    AND title LIKE '%$search%'
    ";
}

$sql .= "
ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

?>

<div class="card shadow-sm">

    <div class="card-header bg-white">

        <form method="GET" class="mb-3">

            <div class="input-group">

                <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search exams..."
                value="<?php echo htmlspecialchars($search); ?>">

                <button
                type="submit"
                class="btn btn-primary">

                    Search

                </button>

            </div>

        </form>

        <div class="d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                My Exams
            </h4>

            <a
            href="create_exam.php"
            class="btn btn-success">

                Create New Exam

            </a>

        </div>

    </div>

    <div class="card-body">

        <?php if(mysqli_num_rows($result) > 0) { ?>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Exam Title</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th width="320">Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php while($exam = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>

                        <?php echo $exam['id']; ?>

                    </td>

                    <td>

                        <?php echo htmlspecialchars($exam['title']); ?>

                    </td>

                    <td>

                        <?php echo $exam['duration']; ?> mins

                    </td>

                    <td>

                        <?php
                        if($exam['status'] == 'published')
                        {
                            echo '<span class="badge bg-success">Published</span>';
                        }
                        else
                        {
                            echo '<span class="badge bg-secondary">Draft</span>';
                        }
                        ?>

                    </td>

                    <td>

                        <a
                        href="questions.php?exam_id=<?php echo $exam['id']; ?>"
                        class="btn btn-primary btn-sm">

                            Questions

                        </a>

                        <?php if($exam['status'] == 'published') { ?>

                            <a
                            href="unpublish_exam.php?id=<?php echo $exam['id']; ?>"
                            class="btn btn-warning btn-sm">

                                Unpublish

                            </a>

                        <?php } else { ?>

                            <a
                            href="publish_exam.php?id=<?php echo $exam['id']; ?>"
                            class="btn btn-success btn-sm">

                                Publish

                            </a>

                        <?php } ?>

                        <a
                        href="delete_exam.php?id=<?php echo $exam['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this exam and all related questions?');">

                            Delete

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

        <?php } else { ?>

            <div class="alert alert-info">

                No exams found.

            </div>

        <?php } ?>

    </div>

</div>

<?php
require_once dirname(__DIR__) . '/includes/footer.php';
?>