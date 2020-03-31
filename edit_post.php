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

if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {

  $pid = $_GET['pid'];
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "SELECT * FROM posts WHERE id = $pid AND user_id = $uid";
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




$error['title'] = $error['article'] = '';

$page_title = 'Edit Post Form';

if (isset($_POST['submit'])) {

  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $title = trim($title);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $article = trim($article);
  $form_valid = true;

  if (!$title || mb_strlen($title) < 3) {

    $error['title'] = 'Title is required for at least 3 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');

  }

  if (!$article || mb_strlen($article) < 3) {

    $error['article'] = 'Article is required for at least 3 chars';
    $form_valid = false;
    header('HTTP/1.1 400 Not Found');
    
  }

  if ($form_valid) {


    $is_support = $_POST['checkbox'] ?? false;
  if($is_support){
    $is_support = 1;
  } else {
    $is_support = 0;
  }

    $uid = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "UPDATE posts SET title = '$title', article = '$article', support = '$is_support' WHERE id = $pid AND user_id = $uid";
    $result = mysqli_query($link, $sql);
    header('HTTP/1.1 200 Ok');

    webhook_post("Post by $uid has been edit!");

    if ($result) {
      if(!$is_support){
        $_SESSION['message'] = "Post $pid has been edit!";
        header('location: blog.php');
        exit;
      } else{
        $_SESSION['message'] = "Post $pid [SUPPORT] has been edit!";
        header('location: support_blog.php');
        exit;
      }
      $_SESSION['message'] = "Post $pid has been edit!";
    }
  }
}


?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Edit your Post</h1>
        <p>Lorem ipsum dolor sit amet.</p>
      </div>
    </div>
    <div class="row">
    <?php header('HTTP/1.1 200 Ok'); ?>
      <div class="col-lg-6">
        <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="title"><code>*</code> Title</label>
            <input type="text" name="title" class="form-control" id="title" value="<?= $post['title']; ?>">
            <span class="text-danger"><?= $error['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article"><code>*</code> Article</label>
            <textarea class="form-control" name="article" id="article" cols="30" rows="10"><?= $post['article']; ?></textarea>
            <span class="text-danger"><?= $error['article']; ?></span>
            <span id="article1"></span>
          </div>
          
          <?php
          
          if($post['support']){
            $is_ch = 'checked';
          } else {
            $is_ch = null;
          }
          
          ?>
          <div style="user-select: none;" class="custom-control custom-switch">
          <input <?= $is_ch ?> id="checkbox" name="checkbox" type="checkbox" class="custom-control-input" id="checkbox">
          <label class="custom-control-label" for="checkbox">Is Support Ticket</label>
          </div><br />
          
          <input type="submit" value="Update Post" name="submit" id="submit" class="btn btn-primary">
          <a href="blog.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>