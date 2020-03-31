<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';

if (auth_user()) {

  header('location: ./');
  exit;
}


$page_title = 'Signup Page';

$error['name'] = $error['email'] = $error['password'] = $error['image'] = '';

if (isset($_POST['submit'])) {

  if (isset($_SESSION['csrf_token']) && isset($_POST['csrf_token']) && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
    // filter inputs from user && clean 

    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = trim($name);
    $name = mysqli_real_escape_string($link, $name);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    $email = mysqli_real_escape_string($link, $email);

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = trim($password);
    $password = mysqli_real_escape_string($link, $password);

    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
    $password2 = trim($password2);
    $password2 = mysqli_real_escape_string($link, $password2);

    $form_valid = true;
    $image_name = 'default_profile.png';

    if (!$name || mb_strlen($name) < 2 || mb_strlen($name) > 100) {

      $form_valid = false;
      $error['name'] = 'Name is required for 2 - 100 chars';
      header('HTTP/1.1 400 Not Found');
    }

    /* Email valiation  */ 
    if (!$email) {

      $form_valid = false;
      $error['email'] = 'A valid email is required';
      header('HTTP/1.1 400 Not Found');

    } elseif (email_exist($email, $link)) {

      $form_valid = false;
      $error['email'] = 'Email is taken';
      header('HTTP/1.1 400 Not Found');

    }

    /* Password validation NoN regex */ 
    if (!$password || strlen($password) < 6 || strlen($password) > 20) {
      $form_valid = false;
      $error['password'] = 'Password is required for 6 - 20 chars';
      header('HTTP/1.1 400 Not Found');
    }


    if($password != $password2){
      $form_valid = false;
      $error['password'] = 'The First Password Didn\'t mathed to the second!';
      header('HTTP/1.1 400 Not Found');
    }

    // check user PFP and validate 
    if ($form_valid && isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {

      if (check_avatar($_FILES)) {
        $image_name = date('Y.m.d.H.i.s') . '-' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image_name);
      } else {
        $form_valid = false;
        $error['image'] = 'File must be an image with size 5mb total';
        header('HTTP/1.1 400 Not Found');
      }
    }

    /* if form is valid send everything to the DB and login the user  */ 
    if ($form_valid) {

      $user_ip = $_SERVER['REMOTE_ADDR'];

      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES(null, '$name', '$email', '$password', 'This user prefers to keep their biography a mystery.', '$user_ip')";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_affected_rows($link) > 0) {
        $uid = mysqli_insert_id($link);
        $sql = "INSERT INTO users_profile VALUES(null, $uid, '$image_name')";
        $result = mysqli_query($link, $sql);
        if ($result &&  mysqli_affected_rows($link) > 0) {

          // create sessions on user logged in / signup (user ID,EMAIL,NAME,IP,AGENT)
          $_SESSION['user_id'] = $uid;
          $_SESSION['user_mail'] = $email;
          $_SESSION['user_name'] = $name;
          $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

          webhook_post("NEW: user signup! welcome
          user-id: $uid,
          user-mail: $email,
          user-name: $name,
          user-ip: " . $_SERVER['REMOTE_ADDR'] . "

          
          ");
          $_SESSION['message'] = 'Welcome ' . $_SESSION['user_name']; '! To Discord Portal, have fun.';
          header('location: blog.php');
          exit;
          
        }
      }
    }
  }

  $token = csrf_token();
} else {
  header('HTTP/1.1 599 Not Found');
  $token = csrf_token();
}

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Here you can signup for new account</h1>
        <p>Have an Account? <a href="signin.php">Sign in</a></p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="signup-form" action="" method="POST" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="name-field"><code>* </code>Name</label>
            <input value="<?= old('name'); ?>" type="text" name="name" id="name-field" class="form-control">
            <span class="text-danger"><?= $error['name']; ?></span>
          </div>
          <div class="form-group">
            <label for="email-field"><code>* </code>Email</label>
            <input value="<?= old('email'); ?>" type="email" name="email" id="email-field" class="form-control">
            <span class="text-danger"><?= $error['email']; ?></span>
          </div>
          <div class="form-group">
            <label for="password-field"><code>* </code>Password</label>
            <input type="password" name="password" id="password-field" class="form-control">
            <span class="text-danger"><?= $error['password']; ?></span>
          </div>
          <div class="form-group">
            <label for="password-field"><code>* </code>Re-type the password for verify</label>
            <input type="password" name="password2" id="password-field" class="form-control">
          </div>
          <div class="form-group">
            <label for="image-field">Profile Image:</label>
          </div>
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="image-field-span">Upload</span>
              </div>
              <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="image-field">
                <label class="custom-file-label" for="image-field">Choose file</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <span class="text-danger"><?= $error['image']; ?></span>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Signup</button>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>