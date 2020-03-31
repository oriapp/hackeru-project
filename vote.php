<?php 

session_start();
require_once 'app/helpers.php';
include_once 'app/minifier.php';
$page_title = 'vote';

if(!$_SESSION['user_id']){
    header('location: signin.php');
    $_SESSION['message'] = "Before voting for posts pls login first.";
    die;
}

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

$pid = null;
if(isset($_GET['p'])){
    $pid = $_GET['p'];
} else {
    header('location ./');
    die;
}

$pid = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING, FILTER_VALIDATE_URL);

$user_id = $_SESSION['user_id'];
$post_id = $pid;

$sql = "SELECT * FROM posts
WHERE id = '$pid' AND support != '1'";
$result = mysqli_query($link, $sql);
$resRes = mysqli_num_rows($result);

if (isset($_POST['submit'])) {
/* get the user if it equals to the id from the url after q= */


$uname = $_SESSION['user_name'];
$sql_likes = "INSERT INTO likes VALUES(NULL,$user_id,$post_id, '$uname', NULL);";

$result_likes = mysqli_query($link,$sql_likes);

$_SESSION['message'] = "Thanks for voting to post $post_id";

header('location: blog.php');
}

$error = null;

?>



<?php include_once 'tpl/header.php'; ?>

    <?php
    $sql_voted = "SELECT user_id FROM likes
    WHERE user_id =" . $_SESSION['user_id'] . " AND post_id = $pid";
    $res_already = mysqli_query($link,$sql_voted);


    $sql_likes_count = "SELECT * FROM likes
                WHERE post_id =" . $pid;
                $result_likes_count = mysqli_query($link,$sql_likes_count);
                $votes_count = mysqli_num_rows($result_likes_count);
    
    ?>


<?php if($resRes == 0): ?>
  <?php header('HTTP/1.1 404 Not Found'); ?>
<center>
<h1 class="text-white">Post with id '<code class="text-white"><?=$pid?></code>' didn't found</h1>
</center>
<?php die; ?>
<?php endif; ?>

<?php if(mysqli_fetch_array($res_already)['user_id'] == $_SESSION['user_id']): ?>

    <main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Here you can vote to <?=$pid?></h1>
      </div>
    </div>
    <div class="col-lg-4 mt-4 float-right">
        <img style="background-color: #2A2D32; user-select: none;" class="img-fluid img-thumbnail" src="images/tumblr_pvc1a4U2ez1tqxdnpo1_500.png">
      </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="signin-form" autocomplete="off" novalidate="novalidate">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <h2>Has <?=$votes_count?> votes</h2>
          <button type="button" class="btn btn-lg btn-primary" disabled>Up Vote <i class="far fa-thumbs-up"></i></button><br>
          <span class="text-danger">YOU ALREADY VOTED!</span>
        </form>
      </div>
    </div>
  </div>
  <div class="mb-4 mouse_scroll">

		<div class="mouse">
			<div class="wheel"></div>
		</div>
		<div>
			<span class="m_scroll_arrows unu"></span>
			<span class="m_scroll_arrows doi"></span>
			<span class="m_scroll_arrows trei"></span>
		</div>
</div>
</main>
<?php else: ?>
    <main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">Here you can vote to <?=$post_id?></h1>
      </div>
    </div>
    <div class="col-lg-4 mt-4 float-right">
        <img style="background-color: #2A2D32; user-select: none;" class="img-fluid img-thumbnail" src="images/tumblr_pvc1a4U2ez1tqxdnpo1_500.png">
      </div>
    <div class="row">
      <div class="col-lg-6">
        <form id="signin-form" action="" method="POST" autocomplete="off" novalidate="novalidate">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <h2>Has <?=$votes_count?> votes</h2>
          <button type="submit" name="submit" class="btn btn-primary">Up Vote <i class="far fa-thumbs-up"></i></button>
          <span class="text-danger"><?= $error; ?></span>
        </form>
      </div>
    </div>
    <div class="mouse_scroll">

		<div class="mouse">
			<div class="wheel"></div>
		</div>
		<div>
			<span class="m_scroll_arrows unu"></span>
			<span class="m_scroll_arrows doi"></span>
			<span class="m_scroll_arrows trei"></span>
		</div>
</div>
  </div>
</main>


<?php endif; ?>


<?php
$sqlis = "SELECT * FROM likes
WHERE post_id = $pid";
$res = mysqli_query($link,$sqlis);
?>
<?php if($res && mysqli_num_rows($res) > 0) : ?>
<h1 class="text-center">Votes</h1>
<table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User ID</th>
      <th scope="col">User Name</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $loop = 0;
  while($post = mysqli_fetch_assoc($res)){
    echo '
    
    <tr>
      <th scope="row">' . ++$loop . '</th>
      <td>'. $post['user_id'] .'</td>
      <td>'. htmlentities($post['user_name']) . '</td>
      <td>'. date($post['date']) .'</td>
    </tr>
    
    ';
  }
  ?>
  </tbody>
</table>
<?php endif; ?>

<?php include_once 'tpl/footer.php' ?>
<?php include 'app/status.php'; ?>