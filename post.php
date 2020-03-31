<?php

session_start();
include_once 'app/minifier.php';
require_once 'app/helpers.php';
$page_title = 'Post Page';
header('HTTP/1.1 201 Ok');

$pid = null;
if(isset($_GET['p'])){
    $pid = $_GET['p'];
} else {
    header('location ./');
}

$pid = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING, FILTER_VALIDATE_URL);

$error['article'] = '';


$article = $_POST['article'] ?? '';
$article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$article = trim($article);


$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$sql = "SELECT * FROM posts
WHERE id = '$pid'";
$result = mysqli_query($link,$sql);


if(isset($_POST['submit'])){
    
    $uid = $_SESSION['user_id'];
    $uname = $_SESSION['user_name'];
    $form_valid = true;
    

    if(strlen($article) < 10){
        $error['article'] = 'A valid command need to have more than 10 letters!';
        $form_valid = false;
        header('HTTP/1.1 400 Not Found');
    }


    if(!$uid){
      $error['article'] = "Pls Login before posting things!";
      $form_valid = false;
      header('HTTP/1.1 400 Not Found');
      $_SESSION['error_alert'] = "You cannot post commands without logging in!";
      header('location: signin.php');
    }


    if($form_valid){
        $article = mysqli_real_escape_string($link,$article);
        $sql_insert = "INSERT INTO commands (id, user_id, post_id, article, user_name) VALUES (NULL, $uid, $pid, '$article', '$uname')";
        $result_insert = mysqli_query($link,$sql_insert);

        $_SESSION['message'] = "comment has been added! <a href='post.php?p=$pid'>Go Back</a>";
        echo "<script>window.location.href='blog.php';</script>";
    }
}


$sql_commands = "SELECT * FROM commands
WHERE post_id = '$pid'
ORDER BY id DESC";

$sql_commands_res = mysqli_query($link,$sql_commands);
?>

<?php include 'tpl/header.php'; ?>
<?php while($post = mysqli_fetch_assoc($result)): ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4 text-center">
        <h1 class="display-4 mb-5"><?=$post['title'];?></h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 mt-4">
      </div>

      <main class='container-fluid'>
  <div>
    <h3 class="text-white">
      Article
    </h3>
    <div>

      <div class="alert alert-warning" role="alert">
        <h5 class="alert-heading">
        Posted At: <?=$post['date']?>
        </h5>

        <p class="text-dark display-4">
        <?= $post['article'] ?>
        <br>
        <a href="vote.php?p=<?=$pid?>" class="btn btn-outline-dark" role="button" aria-pressed="true"><i class="far fa-thumbs-up"></i> Upvote</a>
        </p>
      </div>
    </div>
  </div>
    </div>
    <br>
    <div style="padding-top: 100px" class="container mt-4">

    <hr style="border-top: 1px solid white; width: auto">

    <?php if($_SESSION['user_id']): ?>
        <br><br>

    <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="article"><i class="far fa-comment-alt"></i> Reply</label>
            <input placeholder="Reply  to post number <?= $pid; ?> | Minimum of 10 letters!" type="text" name="article" class="form-control" id="article">
            <span class="text-danger"><?= $error['article']; ?></span>
          </div>

          <input type="submit" value="Post" name="submit" id="submit" class="btn btn-primary">
        </form>

        <br><br>
    <?php else: ?>
<br><br>

    <form id="add-post-form" action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="article"><i class="far fa-comment-alt"></i> Reply</label>
            <input disabled type="text" name="article" class="form-control" id="article" value="<?=old("article")?>">
            <span class="text-danger"><?= $error['article']; ?></span>
            <span class="text-danger">Request: Login before posting something</span>
          </div>

          <input type="submit" value="Post" name="submit" id="submit" class="btn btn-primary">
        </form>

        <br><br>
    <?php endif; ?>

         <?php while($post_res = mysqli_fetch_assoc($sql_commands_res)): ?>


          <?php 
          $user_id = $post_res['user_id'];
          $sql_pfp = "SELECT * FROM users_profile
          WHERE user_id = '$user_id'";
          $result_pfp = mysqli_query($link, $sql_pfp);
          $res = mysqli_fetch_assoc($result_pfp);
          ?>


            <div class="container">
	<div class="row">
		 <div class="media comment-box">
            <div class="media-left">
                <a href="profile.php?q=<?=$post_res['user_id']?>">
                    <img class="img-responsive user-photo" src="images/<?=$res['image_name']?>">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><a href="profile.php?q=<?=$post_res['user_id']?>"><?= $post_res['user_name']; ?></a></h4>
                <p style="width: 1000px"><?= htmlentities($post_res['article']); ?>
              <br>
              &nbsp;&nbsp;&nbsp; At: <?= $post_res['date'] ?>
              </p>

            </div>
        </div>
	</div>
</div>
         <?php endwhile; ?>
            </div>
        </div>
	</div>

  
  </div>
</main>
<?php endwhile; ?>
<?php if(mysqli_num_rows($result) == 0 || !$result): ?>

    <?php header('HTTP/1.1 404 Not Found'); ?>
<center>
<h1 class="text-white">Post with id '<code class="text-white"><?=$pid?></code>' didn't found</h1>
</center>

<?php endif; ?>

<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>