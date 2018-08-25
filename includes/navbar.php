<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Company Name</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">

        
        <?php if(user::logged_in()) { ?>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)"><?php echo $name = $account->fname.' '.$account->lname;?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$site_url;?>logout">Logout</a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?=$site_url;?>register">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$site_url;?>login">Login</a>
        </li>
      <?php } ?>
      </ul>
    </div>
  </div>
</nav>