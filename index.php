<?php
	require('classes/api.php');
	require('includes/header.php');
	require('includes/navbar.php');
?>
<div class="container">
    <div class="row">
      	<?php
      		require('includes/sidebar.php');
      		if(isset($_GET['page']) && isset($_GET['folder'])) {
      			$folder = $_GET['folder'];
      			$page = $_GET['page'];
      			require('pages/'.$folder.'/'.$page.'.php');
      		}
      	?>
    </div>
</div>
<?php
  	require('includes/footer.php');
?>