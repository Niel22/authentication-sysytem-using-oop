<?php require "../config/server.php"; ?>
<?php require "../libs/app.php"; ?>
<?php require "../includes/header.php"; ?>
<?php

$app->redirect();

if(isset($_POST['submit'])){

  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE email = :email";
  $arr = [
    ":email" => $email,
  ];
  $path = APPURL;

  $app->loginUser($query, $arr, $password, $path);
}

?>

<main class="form-signin w-50 m-auto">
  <form method="post" action="login.php">
    <!-- <img class="mb-4 text-center" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="h3 mt-5 fw-normal text-center">Please sign in</h1>

    <?php if ($app->login_status == "Password Incorrect" || $app->login_status == "Email Incorrect"): ?>
      <div class="alert alert-danger" role="alert">
      Email or password is not correct
      </div>
    <?php endif; ?>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
    <h6 class="mt-3">Don't have an account  <a href="register.php">Create your account</a></h6>
  </form>
</main>
<?php require "../includes/footer.php"; ?>
