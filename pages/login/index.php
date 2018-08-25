<?php

  User::logged_in_redirect();

  if(!empty($_POST)) {
  	/* Clean email and encrypt the password */
  	$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_STRING);;
  	$_POST['password'] = User::encrypt_password($_POST['email'], $_POST['password']);

  	/* Check for any errors */
  	if(empty($_POST['email']) || empty($_POST['password'])) {
  		$_SESSION['error'][] = 'You must fill all the fields !';
  	}
    if(User::x_exists('email', $_POST['email'])==false) {
      $_SESSION['error'][] ='The introduced email does not exist !';
    }

  	if(User::login($_POST['email'], $_POST['password'])==false) {
  		$_SESSION['error'][] = "We couldn't sign you in with those credentials !";
  	}

  	if(!empty($_POST) && empty($_SESSION['error'])) {
  		$_SESSION['id'] = User::login($_POST['email'], $_POST['password']);
  		redirect('profile');
  	}
  
  }

?>

<div class="col-lg-9">
  <h3 class="my-4">Login</h3>

  <?php if(!empty($_POST)) {
    display_notifications();    
  } ?>

  <form method="post">
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <!-- For success/fail messages -->
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>