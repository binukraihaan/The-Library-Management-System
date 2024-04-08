<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page" style="background: #ededed">
<div class="login-box">
  	<div class="login-logo">
  		<h2><b>Library Section</b></h2>
  		<p style="font-size:medium;">ABC Institute Of Informatics</p>
  	</div>
  
  	<div class="login-box-body"  style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
    	<p class="login-box-msg" style="font-size: medium";>Get into the Libraria</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" style="height: 40px;" placeholder="Enter the username" required autofocus>
        		<!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" style="height: 40px;" name="password" placeholder="Enter the password" required>
            <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
          </div>
      		<div class="row">
    			<div class="col-xs-12">
          			<button type="submit" class="btn btn-primary btn-lg btn-block" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
      		</div>
    	</form>
  	</div>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>