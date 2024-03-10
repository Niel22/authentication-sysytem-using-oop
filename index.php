<?php require "config/server.php";?>
<?php require "libs/app.php";?>
<?php require "includes/header.php"; ?>


<?= isset($_SESSION['user_id']) ? "hello ".$_SESSION['username'] : "";?>
<?php require "includes/footer.php"; ?>
