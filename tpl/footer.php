<br>
<br>
<br>
    <footer class="footer">
      <!-- Footer -->
<footer class="page-footer font-small mdb-color pt-4 text-white" style="background-color: #23272A !important;">

<div class="container text-center text-md-left">

  <div class="row text-center text-md-left mt-3 pb-3">

    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
      <h6 class="text-uppercase mb-4 font-weight-bold">Discord Portal</h6>
      <p>Discord Portal &trade;<br>
      "API Docs for Bots and Developers 
       Support blog"
      </p>
    </div>


    <hr class="w-100 clearfix d-md-none">

    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
      <h6 class="text-uppercase mb-4 font-weight-bold">Pages</h6>
      <p>
        <a class="text-white" href="./">Home</a>
      </p>
      <p>
        <a class="text-white" href="./about.php">About</a>
      </p>
      <p>
        <?php if(isset($_SESSION['user_id'])): ?>
          <a class="text-white" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="text-white" href="signin.php">Log in</a>
        <?php endif; ?>
      </p>
      <p>
        <a class="text-white" href="blog.php">Posts</a>
      </p>
    </div>

    <hr class="w-100 clearfix d-md-none">

    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
      <h6 class="text-uppercase mb-4 font-weight-bold">Useful links</h6>
      <p>
        <a class="text-white" href="support_blog.php">Help</a>
      </p>
      <p>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a class="text-white" href="profile.php?q=<?=$_SESSION['user_id']?>">Your Account</a>
        <?php endif; ?>
      </p>
      <p>
        <a class="text-white" target="_blank" href="discordapp.com">Members Online: <?=@server_count()?> </a>
      </p>
    </div>

    <hr class="w-100 clearfix d-md-none">

    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
      <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
      <p>
        <i class="fas fa-home mr-3"></i> Tel Aviv, Israel</p>
      <p>
        <i class="fas fa-envelope mr-3"></i> plbwymw@gmail.com</p>
        <p>
        <i class="fas fa-phone mr-3"></i> +972 549-0826-78</p>
          
    </div>

  </div>

  <hr>

  <div class="row d-flex align-items-center">

    <div class="col-md-7 col-lg-8">

      <p class="text-center text-md-left">© <?= date('Y')?> Copyright:
        <a target="_blank" href="http://about-rcn.me/">
          <strong> about-rcn.me</strong>
        </a>
      </p>

    </div>
    <div class="col-md-5 col-lg-4 ml-lg-0">

      <div class="text-center text-md-right">
        <ul class="list-unstyled list-inline">
          <li class="list-inline-item">
            <a href="https://discord.gg/tpT5p8g" target="_blank" class="btn-floating btn-sm rgba-white-slight mx-1">
              <i class="fab fa-discord text-white"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="https://twitter.com/OriApple" target="_blank" class="btn-floating btn-sm rgba-white-slight mx-1">
              <i class="fab fa-twitter text-white"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="https://www.linkedin.com/in/ori-applebaum" target="_blank" class="btn-floating btn-sm rgba-white-slight mx-1">
              <i class="fab fa-linkedin-in text-white"></i>
            </a>
          </li>
        </ul>
      </div>

    </div>

  </div>

</div>

</footer>
    </footer>


    <style>
    main,body{background-color: #2A2D32 !important;}
  h1,p,label,h2{
  color: white;
  }
    </style>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">