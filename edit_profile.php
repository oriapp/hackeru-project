<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$uid = $_SESSION['user_id'];

if(!($_SESSION['user_id'] == $_GET['q'])){
  header('location: logout.php');
  exit;
}

$error['email'] = $error['email'] = $error['name'] = $error['description'] = '';

if (isset($_GET['q'])) {

  $pid = $_GET['q'];
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "SELECT * FROM users WHERE id = $pid";
  $result = mysqli_query($link, $sql);

  if ($result && mysqli_num_rows($result) > 0) {

    $post = mysqli_fetch_assoc($result);
  } else {
    header('location: blog.php');
    exit;
  }
} else {
  header('location: blog.php');
  exit;
}


$page_title = 'Edit Profile';


  $name_fill = 'null';

  if(!$error){
    $name_fill = old('name');
  } else {
    $name_fill = $_SESSION['user_name'];
  }


if (isset($_POST['submit'])) {

  // clear all inputs from SQL Injection and XSS (and few others)
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $name = trim($name);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_EMAIL);
  $email = trim($email);
  $email_regex = "/^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{2,35}@[\w.\-]+\.[a-zA-Z]{2,15}$/";
  $description = filter_input(INPUT_POST, 'description');
  $description = str_replace("'", '`', $description);
  $description = trim($description);
  $form_valid = true;

  if(!(preg_match($email_regex, $email))){
    // check for email validation 
    
    $error['email'] = 'A valid email is required!';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  } elseif (email_exist($email, $link) && !($_SESSION['user_mail'] == $email)){
    // check is others own this email already

    $error['email'] = 'Email is taken';
    $form_valid = false; 
    header('HTTP/1.1 400 Not Found');

  }


  if (mb_strlen($name) < 2){

    $error['name'] = 'A valid name should be more than 2 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  } elseif(mb_strlen($name) > 20){

    $error['name'] = 'A valid name can\'t be more than 20 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  } else{
    header('HTTP/1.1 200 Ok');
  }

  if(mb_strlen($description) < 5){

    $error['description'] = 'A valid description should be more than 5 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  } elseif(mb_strlen($description) > 150){

    $error['description'] = 'A valid description can\'t be more than 150 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  } else{
    header('HTTP/1.1 200 Ok');
  }

  if ($form_valid) {

    $uid = $_SESSION['user_id'];
    //$rem = mysqli_real_escape_string($link, $rem);
    //$rem2 = mysqli_real_escape_string($link, $rem2);
    $sql = "UPDATE users SET name = '$name', email = '$email', description = '$description', ip = '$uip'
     WHERE id = $pid";
    $result = mysqli_query($link, $sql);
    $_SESSION['user_name'] = $name;
    $_SESSION['user_mail'] = $email;

    header('HTTP/1.1 200 Ok');
    webhook_post("$name has been edit he's own profile [USER-ID: $uid]");

    if ($result) {
      $_SESSION['message'] = 'Edit your accout';
      header("location: profile.php?q=$uid");
      exit;
    }
  }
}



$email_fill = 'null';

  if(!$error){
    $email_fill = old('email');
  } else {
    $email_fill = $_SESSION['user_mail'];
  }


?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Edit your profile</h1>
        <p style="user-select: none;">Account: <br />
            ID: <?= $uid; ?><br />
            Name: <?= htmlentities($_SESSION['user_name']);?><br />
            System: <?= user_os(); ?><br />
            IP: <?=$_SERVER['REMOTE_ADDR'];?>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?= htmlentities($name_fill); ?>">
            <span class="text-danger"><?= $error['name']; ?></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" name="email" id="email" value="<?= htmlentities($email_fill); ?>">
            <span class="text-danger"><?= $error['email']; ?></span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description"><?= htmlentities($post['description']);?></textarea>
            <span class="text-danger"><?= $error['description']; ?></span>
          </div>
          <input type="submit" value="Update Post" name="submit" id="submit" class="btn btn-primary">
          <a href="profile.php?q=<?=$uid;?>" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>