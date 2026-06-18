```php
<?php

require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if($_SESSION['role'] != 'admin')
{
    die("Access denied.");
}

$message = "";

if(isset($_POST['create_user']))
{
    $fullname = mysqli_real_escape_string(
        $conn,
        $_POST['fullname']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $role = $_POST['role'];

    $check = mysqli_query(
        $conn,
        "SELECT id FROM users WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0)
    {
        $message = '
        <div class="alert alert-danger">
            Email already exists.
        </div>';
    }
    else
    {
        $sql = "
        INSERT INTO users
        (
            fullname,
            email,
            password,
            role
        )
        VALUES
        (
            '$fullname',
            '$email',
            '$password',
            '$role'
        )
        ";

        if(mysqli_query($conn,$sql))
        {
            $message = '
            <div class="alert alert-success">
                User created successfully.
            </div>';
        }
        else
        {
            $message = '
            <div class="alert alert-danger">
                Failed to create user.
            </div>';
        }
    }
}

$total_users = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total FROM users"
    )
)['total'];

$total_admins = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='admin'"
    )
)['total'];

$total_teachers = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='teacher'"
    )
)['total'];

$total_students = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) total
         FROM users
         WHERE role='student'"
    )
)['total'];

$users = mysqli_query(
    $conn,
    "SELECT *
     FROM users
     ORDER BY id DESC"
);

?>

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold">
            User Management
        </h2>

        <p class="text-muted">
            Manage administrators, teachers, and students.
        </p>

    </div>

    <?php echo $message; ?>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <h3 class="stat-number">

                        <?php echo $total_users; ?>

                    </h3>

                    <p class="mb-0">
                        Total Users
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <h3 class="stat-number">

                        <?php echo $total_admins; ?>

                    </h3>

                    <p class="mb-0">
                        Administrators
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <h3 class="stat-number">

                        <?php echo $total_teachers; ?>

                    </h3>

                    <p class="mb-0">
                        Teachers
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card stat-card">

                <div class="card-body text-center">

                    <h3 class="stat-number">

                        <?php echo $total_students; ?>

                    </h3>

                    <p class="mb-0">
                        Students
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">

                    Create User

                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">

                                Full Name

                            </label>

                            <input
                            type="text"
                            name="fullname"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Role

                            </label>

                            <select
                            name="role"
                            class="form-select">

                                <option value="teacher">
                                    Teacher
                                </option>

                                <option value="student">
                                    Student
                                </option>

                                <option value="admin">
                                    Administrator
                                </option>

                            </select>

                        </div>

                        <button
                        type="submit"
                        name="create_user"
                        class="btn btn-primary w-100">

                            Create User

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header bg-dark text-white">

                    Registered Users

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php
                            while(
                                $row =
                                mysqli_fetch_assoc($users)
                            )
                            {
                            ?>

                            <tr>

                                <td>

                                    #<?php echo $row['id']; ?>

                                </td>

                                <td>

                                    <strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $row['fullname']
                                        );
                                        ?>

                                    </strong>

                                </td>

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $row['email']
                                    );
                                    ?>

                                </td>

                                <td>

                                    <?php

                                    if(
                                        $row['role']
                                        == 'admin'
                                    )
                                    {
                                        echo '
                                        <span class="badge bg-danger">
                                        Admin
                                        </span>';
                                    }
                                    elseif(
                                        $row['role']
                                        == 'teacher'
                                    )
                                    {
                                        echo '
                                        <span class="badge bg-success">
                                        Teacher
                                        </span>';
                                    }
                                    else
                                    {
                                        echo '
                                        <span class="badge bg-primary">
                                        Student
                                        </span>';
                                    }

                                    ?>

                                </td>

                            </tr>

                            <?php } ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
require_once '../includes/footer.php';
?>
```
