<?php include('../includes/header.php'); ?>
<!-- Login form here -->
<form method="post" action="">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit" name="login">Login</button>
</form>
<?php
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    // Perform login logic
}
?>
<?php include('../includes/footer.php'); ?>