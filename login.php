<?php

session_start();

require_once 'includes/db.php';

$message = '';

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE email=? LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if($user = mysqli_fetch_assoc($result))
    {
        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'admin')
            {
                header("Location: admin/dashboard.php");
                exit();
            }
            elseif($user['role'] == 'teacher')
            {
                header("Location: teacher/dashboard.php");
                exit();
            }
            else
            {
                header("Location: student/dashboard.php");
                exit();
            }
        }
    }

    $message = "Invalid email or password.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

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

<div class="col-md-5">

<div class="card">

<div class="card-body p-4">

<div class="text-center mb-4">

<h2>Online Examination System</h2>

<p class="text-muted">
Login to your account
</p>

</div>

<?php if(!empty($message)) { ?>

<div class="alert alert-danger">
<?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

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
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

<div class="text-center mt-3">

<a href="register.php">
Create New Account
</a>

</div>

<div class="text-center mt-2">

<a href="index.php">
Back to Home
</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>