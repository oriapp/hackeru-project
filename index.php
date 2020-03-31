<?php
// x

/* 

TO DO LIST 
________________

NOTHING

*/

session_start();
include_once 'app/minifier.php';
require_once 'app/helpers.php';
$page_title = 'Home Page';

$index = 0;
header('HTTP/1.1 201 Ok');


$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$sql = "SELECT up.image_name, u.name,p.*,DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') pdate FROM posts p 
        JOIN users u ON u.id = p.user_id 
        JOIN users_profile up ON u.id = up.user_id
        ORDER BY RAND(), p.date DESC LIMIT 3";
$result = mysqli_query($link, $sql);


$message = ($_SESSION['user_id'] ?? null) ? "Hello,". $_SESSION['user_name']." <br> It's good to see you!" : "Welcome to Discord Portal Blog!";
$uid = $_SESSION['user_id'] ?? null;
?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4 text-center">
        <h1 class="display-4 mb-5"><?= $message ?></h1>
        <p>Discord Developers Portal</p>
        <a class="btn btn-outline-light btn-lg mt-2" href="blog.php">Start Develop!</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 mt-4">
        <p>A blog to talk / getting support with Discord SDK and Discord.JS, JDA, DiscordPY libraries anywhere and anytime! 😉</p>
      </div>
      <div class="col-lg-4 mt-4">
        <img style="background-color: #2A2D32; user-select: none;" class="img-fluid img-thumbnail" src="images/tumblr_pvc1a4U2ez1tqxdnpo1_500.png">
      </div>
    </div>

    <h2 class="display-4 mb-5">Random Posts</h2>

    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <?php header('HTTP/1.1 201 Ok'); ?>
      <div class="mt-5 row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <div class="col-12 mt-3">
          <h6 class="text-white"><span class="badge badge-secondary"># <?=++$index?></span></h6>
          <div style="background-color: #23272A" class="card">
              <div style="background-color:#7289DA" class="card-title border-bottom p-3">
                <span>
                  <img class="rounded-circle" width="40" src="images/<?= $post['image_name']; ?>">
                  <b class="ml-2"><a class="text-white" style="color: #2A2D32;" href="profile.php?q=<?= htmlentities($post['user_id']); ?>"><?= htmlentities($post['name']); ?></a>
                  <?php if($post['support']):?>
                  &nbsp;<span class="badge badge-secondary">Support Ticket</span>
                <?php endif;?>
                  </b>
                </span>
                <span class="float-right"><?= $post['pdate']; ?></span>
              </div>
              <div class="card-body">
                <h5 class="card-title text-white"><?= htmlentities($post['title']); ?></h5>
                <p class="text-white" class="card-text"><?= str_replace("\n", '<br>', htmlentities(substr($post['article'],0,100))); ?></p>
                <!-- VOTE BUTTON START -->
                <?php 
                $sql_likes_count = "SELECT * FROM likes
                WHERE post_id =" . $post['id'];
                $result_likes_count = mysqli_query($link,$sql_likes_count);
                $ress = mysqli_num_rows($result_likes_count);
                ?>
                <?php if(!($post['support'])): ?>
                <a type="button" class="btn btn-outline-light" href="vote.php?p=<?=$post['id']?>"role="button"><i class="far fa-thumbs-up"></i> <?=$ress?></a>&nbsp;
                <?php endif; ?>
                <!-- VOTE BUTTON END -->
                <?php if(!($post['support'])): ?>
                  <a href="post.php?p=<?=$post['id']?>">Jump to full blog</a>
                <?php endif; ?>
                <?php if ($uid == $post['user_id']) : ?>
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
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>
