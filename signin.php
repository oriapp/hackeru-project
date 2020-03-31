<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';

if (auth_user()){
  header('location: index.php');
  exit;
}


$page_title = 'Signin Page';
$error = '';

if (isset($_POST['submit'])) {

  /* Verified user log */ 
  if (isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    $password = trim($password);

    if (!$email) {

      $error = '* A valid email is reuqired';
      $_SESSION['error_alert'] = "A valid email is reuqired";
      header('HTTP/1.1 400 Not Found');

    } else if (!$password) {

      $error = '* Password is required';
      $_SESSION['error_alert'] = "Password is required";
      header('HTTP/1.1 400 Not Found');
    } else {

      $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

      $email = mysqli_real_escape_string($link, $email);

      $password = mysqli_real_escape_string($link, $password);

      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_mail'] = $user['email'];
          $_SESSION['user_name'] = $user['name'];
          $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
          
          webhook_post($_SESSION['user_name'] . " Has been loggen in!");

          $_SESSION['message'] = 'Loggen In! Hello ' . $_SESSION['user_name'];
          header('location: blog.php');
          exit;
        } else {

          $error = '* Wrong email or password conmbination';
          $_SESSION['error_alert'] = "Wrong email or password conmbination!";

        }
      } else {

        $error = '* Wrong email or password conmbination';
        $_SESSION['error_alert'] = "Wrong email or password conmbination!";
        
      }
    }
  }

  $token = csrf_token();
} else {

  $token = csrf_token();
}

?>


<?php message_alert(); ?>
<?php error_alert(); ?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Here you can signin with your account</h1>
        <p>No account? <a href="signup.php">Create New Account</a></p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="signin-form" action="" method="POST" autocomplete="off" novalidate="novalidate">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="email-field">* Email</label>
            <input value="<?= old('email'); ?>" type="email" name="email" id="email-field" class="form-control">
          </div>
          <div class="form-group">
            <label for="password-field">* Password</label>
            <input type="password" name="password" id="password-field" class="form-control">
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Signin</button>
          <span class="text-danger"><?= $error; ?></span>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>