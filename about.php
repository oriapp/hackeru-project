<?php

session_start();
session_regenerate_id();

require_once 'app/helpers.php';
include_once 'app/minifier.php';
$page_title = 'About Us';

?>

<?php include 'tpl/header.php'; ?>
<main class="min-h-900">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <h1 class="display-4">About Ori Appelbaum</h1>

        <div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://about-rcn.me/"></iframe>
</div><br />

<a class="buttonPrimary-3RahU_ button-2A8AGi" target="_blank" href="https://about-rcn.me">See Full Website</a>


      </div>
    </div>
  </div>
</main>
<?php include 'tpl/footer.php'; ?>
<?php include 'app/status.php'; ?>