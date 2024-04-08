<header class="main-header">
  <nav class="navbar navbar-static-top" style="background-color: #333;">
    <div class="container">
      <div class="navbar-header">
        <a href="index.php" class="navbar-brand"><b>LIBRARIA</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <?php
            if(isset($_SESSION['student'])){
              echo "
                <li><a href='transaction.php'>TRANSACTION</a></li>
              ";
            } 
          ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php
            if(isset($_SESSION['student'])){
              $photo = (!empty($student['photo'])) ? 'images/'.$student['photo'] : 'images/profile.jpg';
              echo "
                <li class='user user-menu'>
                  <a href='#'>
                    <img src='".$photo."' class='user-image' alt='User Image'>
                    <span class='hidden-xs'>".$student['firstname'].' '.$student['lastname']."</span>
                  </a>
                </li>
                <li><a href='logout.php'>NEXT STUDENT &nbsp<i class='fa fa-arrow-right'></i></a></li>
              ";
            }
            else{
              echo "
                <li><a href='#login' data-toggle='modal'><i class='fa fa-id-badge'></i>&nbsp Search By User</a></li>
                <li><a href='./admin'><i class='fa fa-power-off'></i>&nbsp   ADMIN LOGIN</a></li>
              ";
            } 
          ?>
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>
<?php include 'includes/login_modal.php'; ?>