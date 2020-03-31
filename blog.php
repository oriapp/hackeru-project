<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';
$page_title = 'Blog Page';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
# select from db user image, user name, replace the date format. where support ticket is false SELECT FROM THE NEWE POST TO THE LAST
$sql = "SELECT up.image_name, u.name,p.*,DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') pdate FROM posts p
            JOIN users u ON u.id = p.user_id 
            JOIN users_profile up ON u.id = up.user_id
            WHERE support = '0'
            ORDER BY p.date DESC";
$result = mysqli_query($link, $sql);
$uid = $_SESSION['user_id'] ?? null;

$sql_likes = "SELECT * FROM likes";
            $result_likes = mysqli_query($link, $sql_likes);
            $likes = mysqli_fetch_assoc($result_likes);

?>

<?php include 'tpl/header.php'; ?>


<?php message_alert(); error_alert();?>


<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Blog Page</h1>
        <p class="mt-3">
          <?php if (auth_user()) : ?>
            <a href="add_post.php" class="btn btn-primary">+ Add New Post</a>
          <?php else : ?>
            <a href="signup.php" class="btn btn-primary">Create Account And Start Talk!</a>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <?php header('HTTP/1.1 200 Ok'); ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <!-- Jump to post -->
          <a name="id=<?= $post['id'] ?>"></a>

          <div class="col-12 mt-3">
            <div style="background-color: #23272A" class="card">
              <div style="background-color:#7289DA" class="card-title border-bottom p-3">
                <span>
                  <img class="rounded-circle rounded" width="40" src="images/<?= $post['image_name']; ?>">
                  <b class="ml-2"><a class="text-white" href="profile.php?q=<?= htmlentities($post['user_id']); ?>"><?= htmlentities($post['name']); ?></a></b>
                </span>
                <span class="float-right"><?= $post['pdate']; ?></span>
              </div>
              <div class="card-body">
                <h5 class="card-title"><a style="color:#99AAB5" href="post.php?p=<?=$post['id']?>"><?= htmlentities($post['title']); ?></a></h5>
                <p class="text-white" class="card-text" style="color: black;"><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>
                <?php if ($uid == $post['user_id']) : ?>
                <!-- If user is logged in and he's connected to the same accout of the same post let 'em edit he's post / delete -->
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
                <!-- VOTE BUTTON START -->
                <?php 
                $sql_likes_count = "SELECT * FROM likes
                WHERE post_id =" . $post['id'];
                $result_likes_count = mysqli_query($link,$sql_likes_count);
                $ress = mysqli_num_rows($result_likes_count);
                ?>
                <hr />
                <a class="btn btn-outline-light" href="vote.php?p=<?=$post['id']?>"role="button"><i class="far fa-thumbs-up"></i> <?=$ress?></a>
                
                <a class="btn btn-outline-light" href="post.php?p=<?=$post['id']?>"role="button"><i class="far fa-comment-dots"></i> Reply</a>
                <!-- VOTE BUTTON END -->
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</main>
<br /><br />
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>