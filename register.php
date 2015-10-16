<?php
session_start();
include_once("functions/users.php");

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $ret = User::create_user(array(
        'email'    => $_POST['email'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ));
    if ($ret) echo "success.<br>";
    else echo "fail.<br>";
}

?>

<form action="register.php" method="post">
    email <input name="email"><br>
    username <input name="username"><br>
    password <input name="password"><br>
    <button type="submit">register</button>
</form>