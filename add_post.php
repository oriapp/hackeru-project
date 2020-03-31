<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';

if (!auth_user()) {

  header('location: signin.php');
  exit;
}


$error['title'] = $error['article'] = '';

$page_title = 'Add Post Form';

if (isset($_POST['submit'])) {

  $is_support = $_POST['checkbox'] ?? false;
  if($is_support){
    $is_support = 1;
  } else {
    $is_support = 0;
  }

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

    $uid = $_SESSION['user_id'];
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "INSERT INTO posts VALUES(null, $uid, '$title', '$article', NOW(), $is_support)";
    try{
    $result = mysqli_query($link, $sql);
    }
    // catch no needed
    finally{
      webhook_post("New post by $uid 
      Title: $title");
      $_SESSION['message'] = 'New Post has been posted!';
    }

    if ($result && mysqli_affected_rows($link) > 0) {

      if($is_support){
        header('location: support_blog.php');
        exit;
      } else {
        header('location: blog.php');
        exit;
      }
      
    }
  }
}


?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">+ Add New Post</h1>
        <p>Post what's in your mind to everyone</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="title"><code style="user-select: none;">* </code>Title</label>
            <input type="text" name="title" class="form-control" id="title" value="<?= old('title'); ?>">
            <span class="text-danger"><?= $error['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article"><code style="user-select: none;">* </code>Article</label>
            <textarea class="form-control" name="article" id="article" cols="30" rows="10"><?= old('article'); ?></textarea>
            <span class="text-danger"><?= $error['article']; ?></span>
            <span id="article1"></span>
          </div>
          
          <div style="user-select: none;" class="custom-control custom-switch">
          <input id="checkbox" name="checkbox" type="checkbox" class="custom-control-input" id="checkbox">
          <label class="custom-control-label" for="checkbox">Is Support Ticket</label>
          </div><br />

          <input type="submit" value="Save Post" name="submit" id="submit" class="btn btn-primary">
          <a href="blog.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>