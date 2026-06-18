<?php

require_once '../includes/auth.php';
require_once '../includes/db.php';

if($_SESSION['role'] != 'admin')
{
    die("Access denied.");
}

$message = "";

if(isset($_POST['create_user']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users(fullname,email,password,role)
            VALUES('$fullname','$email','$password','$role')";

    if(mysqli_query($conn,$sql))
    {
        $message = "User created successfully.";
    }
    else
    {
        $message = "Failed to create user.";
    }
}

?>

<h2>User Management</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <input
        type="text"
        name="fullname"
        placeholder="Full Name"
        required
    >

    <br><br>

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>

    <select name="role">

        <option value="teacher">
            Teacher
        </option>

        <option value="admin">
            Admin
        </option>

    </select>

    <br><br>

    <button name="create_user">
        Create User
    </button>

</form>

<hr>
<h3>All Users</h3>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php

$users = mysqli_query(
    $conn,
    "SELECT * FROM users ORDER BY id DESC"
);

while($row = mysqli_fetch_assoc($users))
{

?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo $row['fullname']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['role']; ?></td>

</tr>

<?php } ?>

</table>