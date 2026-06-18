<?php

require_once 'includes/db.php';

$message = '';

if(isset($_POST['register']))
{
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $role = 'student';

    $check = mysqli_prepare(
        $conn,
        "SELECT id FROM users WHERE email=?"
    );

    mysqli_stmt_bind_param(
        $check,
        "s",
        $email
    );

    mysqli_stmt_execute($check);

    $existing =
        mysqli_stmt_get_result($check);

    if(mysqli_num_rows($existing) > 0)
    {
        $message =
            "Email already exists.";
    }
    else
    {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users
            (fullname,email,password,role)
            VALUES(?,?,?,?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $fullname,
            $email,
            $password,
            $role
        );

        if(mysqli_stmt_execute($stmt))
        {
            $message =
                "Registration successful.";
        }
        else
        {
            $message =
                "Registration failed.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Registration</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="assets/css/style.css"
rel="stylesheet">

</head>

<body>

<div class="container">

<div class="row justify-content-center align-items-center vh-100">

<div class="col-md-6">

<div class="card">

<div class="card-body p-4">

<div class="text-center mb-4">

<h2>Student Registration</h2>

<p class="text-muted">
Create your account
</p>

</div>

<?php if(!empty($message)) { ?>

<div class="alert alert-info">
<?php echo $message; ?>
</div>

<?php } ?>

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

<button
type="submit"
name="register"
class="btn btn-success w-100">

Register

</button>

</form>

<div class="text-center mt-3">

<a href="login.php">
Already have an account?
</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>