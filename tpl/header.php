<!doctype html>
<html lang="en" class="all">
<?php include 'app/helpers.php'; ?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="shortcut icon" href="images/07dca80a102d4149e9736d4b162cff6f.ico" type="image/x-icon">
  <?php 
  $uri = $_SERVER['REQUEST_URI'];
  $uri = str_replace('.php', ' ', $uri);
  ?>
  <meta property="og:site_name" content="Discord Portal">
  <meta name="theme-color" content="#7289DA"/>
  <meta property="og:color" name="og:theme-color" content="#7289DA"/>
  <meta property="og:url" content="https://discord-events.000webhostapp.com">
  <meta property="og:title" content="Discord Events Blog | <?= page_location($uri) ?? 'Home' ?> Page">
  <meta property="og:description" content="A Place For Getting Support With Discord SDK">
  <meta property="og:type" content="website">
  <meta name="og:image" itemprop="image" content="images/logo.svg">

  <title>Discord Portal <?= "| $page_title" ?? ' '; ?></title>
</head>

<style>
  img,a,h1,span,br{
	user-select: none;
}
</style>

<body>

  <header id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-primary" style="background-color: #23272A !important;">
      <div class="container">
        <a class="navbar-brand text-white" href="./"><i class="fab fa-discord fa-2x"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link text-white" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="blog.php">Blog</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <?php if(!auth_user()): ?>
              <li class="nav-item">
              <a class="nav-link text-white" href="signin.php">Sign in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="signup.php">Sign up</a>
            </li>
            <?php else: ?>
              <li class="nav-item">
              <a class="nav-link text-white" href="profile.php?q=<?=$_SESSION['user_id']?>"><?= htmlentities($_SESSION['user_name']); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="logout.php">Logout</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <script data-ad-client="ca-pub-3747511635188274" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

  </header>
  <br>
<br>