<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';
$page_title = 'Support';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
/* SELECT data from db for support tickets where IS_SUPPORT = 1 */
$sql = "SELECT u.email,up.image_name, u.name,p.*,DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') pdate FROM posts p
            JOIN users u ON u.id = p.user_id 
            JOIN users_profile up ON u.id = up.user_id
            WHERE support = '1'
            ORDER BY p.date DESC";
$result = mysqli_query($link, $sql);
$uid = $_SESSION['user_id'] ?? null;

?>

<?php include 'tpl/header.php'; ?>


<?php message_alert(); ?>



<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Support Blog Page</h1><br>
        <p class="mt-3">
          <?php if (auth_user()) : ?>
            <a href="add_post.php" class="btn btn-primary">+ Add New Post</a>
          <?php else : ?>
            <a href="signup.php" class="btn btn-primary">Create an account!</a>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <div class="col-12 mt-3">
            <div class="card">
              <div class="card-title border-bottom p-3">
                <span>
                  <img class="rounded-circle rounded" width="40" src="images/<?= $post['image_name']; ?>">
                  <b class="ml-2"><a href="profile.php?q=<?= htmlentities($post['user_id']); ?>"><?= htmlentities($post['name']); ?> | <?= $post['email']; ?></a></b>
                </span>
                <span class="float-right"><?= $post['pdate']; ?></span>
              </div>
              <div class="card-body">
                <h5 class="card-title"><?= htmlentities($post['title']); ?></h5>
                <p class="card-text" style="color: black;"><?= str_replace("\n", '<br>', htmlentities($post['article']));?></p>
                <br>&nbsp;&nbsp; Ticket ID: <?= $post['id']; ?>
                <?php if ($uid == $post['user_id']) : ?>
                  <div class="dropdown float-right">
                    <a href="#" class="dropdown-toggle dropdown-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                      <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="edit_post.php?pid=<?= $post['id']; ?>"><i class="far fa-edit"></i> Edit</a>
                      <a class="dropdown-item delete-post-btn" href="delete_post.php?pid=<?= $post['id']; ?>"><i class="fas fa-eraser"></i> Delete</a>
                    </div>
                  </div>
                <?php endif; ?>
                <hr />
                <a class="mt-2 btn btn-outline-dark" href="post.php?p=<?=$post['id']?>"role="button"><i class="far fa-comment-dots"></i> Reply</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</main>
<br><br>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>