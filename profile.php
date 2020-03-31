<?php 

session_start();
require_once 'app/helpers.php';
include_once 'app/minifier.php';
$page_title = 'Profile';

$uid = null;
if(isset($_GET['q'])){
    $uid = $_GET['q'];
} else {
    header('location ./');
}

$uid = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING, FILTER_VALIDATE_URL);

/* get the user if it equals to the id from the url after q= */
$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$sql = "SELECT * FROM users
WHERE id = '$uid'";

/* get user avatar from db START */
$sql_image = "SELECT image_name FROM users_profile
WHERE user_id = '$uid'";

$result_image = mysqli_query($link, $sql_image);
$user_avatar = mysqli_fetch_assoc($result_image);
/* get user avatar from db END */


/* get user posts from db START */
$sql_post = "SELECT * FROM posts
WHERE user_id = $uid
ORDER BY date DESC";

$result_post = mysqli_query($link, $sql_post);
//$user_posts = mysqli_fetch_assoc($result_post);
/* get user posts from db END */

$result = mysqli_query($link, $sql);
$user_info = mysqli_fetch_assoc($result);


$short_name = explode(' ', $user_info['name'])['0'];
$short_name = strtolower($short_name);


?>


<?php include 'tpl/header.php'; ?>

<?php message_alert(); ?>
<?php error_alert(); ?>


<?php if ($result && mysqli_num_rows($result) > 0) : ?>
  <?php header('HTTP/1.1 201 Ok'); ?>
<div class="text-center">
  <img style="max-width: 10%; min-width: 10%; border:3px solid #ffffff;" src="images/<?= $user_avatar['image_name']; ?>" class="rounded  rounded-circle" style="max-width: 250px;" alt="Profile image">

  <h1 class="display-4 mb-5 mt-3"><?= htmlentities($user_info['name']) ?>'s Profile</h1>
  <h5 class="text-white mb-5 mt-3"><a style="user-select: none;"><!-- Description --></a> <br><?= htmlentities($user_info['description']) ?></h5>

  <?php $userID = $_SESSION['user_id'] ?? null; if($uid == $userID):?>
    <a href="edit_profile.php?q=<?=$uid;?>" class="btn btn-primary">Edit Profile</a><br><br>
  <?php endif; ?>

  <!-- start -->
  <main class="min-h-900">
  <div class="container">
    <div class="row">

    </div>
    <h3 class="text-white" style="max-width: 100%;"><?= $short_name;?> have <?= mysqli_num_rows($result_post) ?> posts</h3>
  <?php if ($result_post && mysqli_num_rows($result_post) > 0) : ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result_post)) : ?>
          <div class="col-12 mt-3">
          <div style="background-color: #23272A" class="card">
              <div style="background-color:#7289DA" class="card-title border-bottom p-3">
                <span>
                  <img style="border:2px solid #000000;" class="rounded-circle rounded float-left" width="40" src="images/<?= htmlentities($user_avatar['image_name']); ?>">
                  <b class="ml-2"></b>
                </span>&nbsp;
                <?php if($post['support']):?>
                  &nbsp;<span class="float-left badge badge-secondary">Support Ticket</span>
                <?php endif;?>
                <span class="float-right"><?= $post['date']; ?></span>
              </div>
              <div class="card-body">
                <h5  class="card-title text-white"><?= htmlentities($post['title']); ?></h5>
                <p class="card-text text-white" style="color: black;"><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>
                <!-- VOTE BUTTON START -->
                <?php 
                $sql_likes_count = "SELECT * FROM likes
                WHERE post_id =" . $post['id'];
                $result_likes_count = mysqli_query($link,$sql_likes_count);
                $ress = mysqli_num_rows($result_likes_count);
                ?>
                <?php if(!($post['support'])): ?>
                  <hr>
                <a type="button" class="btn btn-outline-light" href="vote.php?p=<?=$post['id']?>"role="button"><i class="far fa-thumbs-up"></i> <?=$ress?></a>&nbsp;
                <a class="btn btn-outline-light" href="post.php?p=<?=$post['id']?>"role="button"><i class="far fa-comment-dots"></i> Reply</a>
                <?php else: ?>
                  <hr>
                  <a class="btn btn-outline-light" href="post.php?p=<?=$post['id']?>"role="button"><i class="far fa-comment-dots"></i> Reply</a>
                <?php endif; ?>
                <!-- VOTE BUTTON END -->
                <?php $sessID = $_SESSION['user_id'] ?? null; if ($uid == $sessID) : ?>
                  <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle dropdown-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                      <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="edit_post.php?pid=<?= $post['id']; ?>"><i class="far fa-edit"></i> Edit</a>
                      <a class="dropdown-item delete-post-btn" href="delete_post.php?pid=<?= $post['id']; ?>"><i class="fas fa-eraser"></i> Delete</a>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- end -->

</div>

<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>

<?php else: ?>
  <?php header('HTTP/1.1 404 Not Found'); ?>
<center>
  <!-- <img src="https://cdn.discordapp.com/avatars/<?=$_SESSION['user_id']?>/<?=$_SESSION['avatar']?>.png" alt=""> -->
<h1 class="text-white">User with id '<code class="text-white"><?=$uid?></code>' didn't found</h1>
</center>
<?php include 'app/status.php'; ?>
<?php endif; ?>