<?php
session_start();
include_once("functions/users.php");


if (isset($_POST['username']) && isset($_POST['password'])) {
    $cur_user->login($_POST['username'], $_POST['password']); 
}
if (isset($_GET['logout'])) {
    $cur_user->logout();
}
echo json_encode($cur_user);

?>


<?php if ($cur_user->get_status()) { ?>
    <p>Hi, <?php echo $cur_user->username?></p>
    <a href="login.php?logout=<?php echo $cur_user->username?>">logout</a>
<?php } else { ?>
    
    <form action="login.php" method="post">
        username <input name="username"><br>
        password <input name="password"><br>
        <button type="submit">login</button>
    </form>
<?php } ?>

