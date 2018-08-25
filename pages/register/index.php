<?php
  User::logged_in_redirect();
  
  if(!empty($_POST)) {

    //print_r($_POST); die;
    /* Clean some posted variables */
    $_POST['email']   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    /* Define some variables */
    $fields = array('fname', 'lname', 'number' ,'email', 'address1', 'address2', 'postal', 'password');

    /* Check for any errors */
    /*if (!preg_match("/^[a-z]$/i", $_POST['fname'])) {
      $_SESSION['error'][] = 'Only Alphabet characters.!';
    }*/
    if(strlen($_POST['fname']) < 3 || strlen($_POST['fname']) > 50) {
      $_SESSION['error'][] = 'Name must be between 3 and 50 characters !';
    }

    /*if (!preg_match("/^[a-z]$/i", $_POST['lname'])) {
      $_SESSION['error'][] = 'Only Alphabet characters.!';
    }*/
    if(strlen($_POST['lname']) < 3 || strlen($_POST['lname']) > 50) {
      $_SESSION['error'][] = 'Name must be between 3 and 50 characters !';
    }


    if(User::x_exists('email', $_POST['email'])) {
      $_SESSION['error'][] = 'We are sorry but that email is already used !';
    }
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
      $_SESSION['error'][] = 'You entered an invalid email !';
    }


    if(User::is_valid_password($_POST['password'])) {
      $_SESSION['error'][] = 'Do not match Password requirements !';
    }
    if(strlen(trim($_POST['password'])) < 8 || strlen(trim($_POST['password'])) > 10) {
      $_SESSION['error'][] = 'Password must be between 8 and 10 characters !';
    }  

    
    if (!preg_match("/^[1-9][0-9]*$/", $_POST['number'])) {
      $_SESSION['error'][] = 'Only numeric characters.!';
    }
    if(strlen(trim($_POST['number'])) < 10 || strlen(trim($_POST['number'])) > 10) {
      $_SESSION['error'][] = 'Number must be 10 digits !';
    }

    if (!preg_match("/^[1-9][0-9]*$/", $_POST['postal'])) {
      $_SESSION['error'][] = 'Only numeric characters.!';
    }
    if(strlen(trim($_POST['postal'])) < 4 || strlen(trim($_POST['postal'])) > 4) {
      $_SESSION['error'][] = 'Postal code must be 4 digits !';
    }

    /*if (!preg_match("/^[a-z]$/i", $_POST['address1'])) {
      $_SESSION['error'][] = 'Only Alphabet characters.!';
    }*/
    if(strlen(trim($_POST['address1'])) > 50) {
      $_SESSION['error'][] = 'Postal code must be 4 digits !';
    }

    /*if (!preg_match("/^[a-z]$/i", $_POST['address2'])) {
      $_SESSION['error'][] = 'Only Alphabet characters.!';
    }*/
    if(strlen(trim($_POST['address2'])) > 50) {
      $_SESSION['error'][] = 'Postal code must be 4 digits !';
    }
   
       
    /* If there are no errors continue the registering process */
    if(empty($_SESSION['error'])) {
      /* Define some needed variables */
      $password = User::encrypt_password($_POST['email'], $_POST['password']);
      $date = new DateTime();
      $date = $date->format('Y-m-d H:i:s');
      array('fname', 'lname', 'number' ,'email', 'address1', 'address2', 'postal', 'password');
      /* Add the user to the database */
      $stmt = $database->prepare("INSERT INTO `users` (`fname`, `lname`, `number`, `email`, `address1`, `address2`, `postal`, `password`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param('sssssssss', $_POST['fname'], $_POST['lname'], $_POST['number'], $_POST['email'], $_POST['address1'], $_POST['address2'], $_POST['postal'], $password, $date);
      $stmt->execute();
      $stmt->close();
    }   
    
  }
?>


<div class="col-lg-9">
  <h3 class="my-4">Register Account</h3>
  <?php if(!empty($_POST)) {
    display_notifications();    
  } ?>

  <form method="post">
    

    <div class="row">
    <div class="col-md-12">
    <div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <label>First Name:</label>
          <input type="text" class="form-control" name="fname" required>
      </div>

      <div class="form-group">
          <label>Last Name:</label>
          <input type="text" class="form-control" name="lname" required>
      </div>

      <div class="form-group">
          <label>Phone Number</label>
          <input type="text" class="form-control" name="number" required>
      </div>

      <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
          <label>Address Line 1</label>
          <input type="text" class="form-control" name="address1" required>
      </div>

      <div class="form-group">
          <label>Address Line 2</label>
          <input type="text" class="form-control" name="address2" required>
      </div>

      <div class="form-group">
          <label>Postal Code</label>
          <input type="text" class="form-control" name="postal" required>
      </div>

      <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" name="password" required>
      </div>
    </div>
    </div>
    </div>
    </div>


    <!-- For success/fail messages -->
    <button type="submit" class="btn btn-primary" >Register</button>
  </form>
</div>
