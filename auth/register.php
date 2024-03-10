<?php require "../config/server.php"; ?>
<?php require "../libs/app.php"; ?>
<?php require "../includes/header.php"; ?>
<?php

$app->redirect();

if (isset($_POST['submit'])) {

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $q = "SELECT * FROM users WHERE email = :email";
  $param = [":email" => $email];
  $query = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
  $arr = [
    ":email" => $email,
    ":username" => $username,
    ":password" => $password
  ];
  $path = "login.php";

  $app->register($query, $arr, $path, $q, $param);

}


?>


<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">

    <h1 class="h3 mt-5 fw-normal text-center">Please Register</h1>
    <?php if ($app->register_status == "Email Already Exist"): ?>
      <div class="alert alert-danger" role="alert">
      Email Already Exist
      </div>
    <?php endif; ?>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" required placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" required placeholder="username">
      <label for="floatingInput">Username</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" required placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">register</button>
    <h6 class="mt-3">Aleardy have an account? <a href="login.php">Login</a></h6>

  </form>
</main>
<?php require "../includes/footer.php"; ?>