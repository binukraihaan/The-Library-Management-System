<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<?php

include('./includes/conn.php');

$selectedRole = isset($_GET['role']) ? $_GET['role'] : '0'; // Assuming you are using GET method to pass selected role value
$where = "";
if ($selectedRole && $selectedRole != '0') {
  $where = " WHERE users.role = '$selectedRole'";
}

$sql = "SELECT *, users.user_id AS stud FROM returns LEFT JOIN users ON users.id=returns.user_id LEFT JOIN books ON books.id=returns.book_id
        $where
        ORDER BY returns.date_return DESC";

$query = $conn->query($sql);

?>

<body class="hold-transition skin-blue sidebar-mini">
<div id="preloader"></div>
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Return Books
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>Transaction</li>
          <li class="active">Return</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
        ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Error!</h4>
            <ul>
              <?php
              foreach ($_SESSION['error'] as $error) {
                echo "
                      <li>" . $error . "</li>
                    ";
              }
              ?>
            </ul>
          </div>
        <?php
          unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-flat"><i class="fa fa-mail-reply"></i> &nbsp; Returns</a>

                <div class="box-tools pull-right">
                  <form class="form-inline">
                    <div class="form-group">
                    <label>Filter By User Role: </label>&nbsp;
                      <select class="form-control input-sm" id="select_role">
                        <option value="0">ALL</option>
                        <?php
                        $sql_roles = "SELECT DISTINCT role FROM users"; // Assuming 'users' table stores user roles
                        $query_roles = $conn->query($sql_roles);
                        while ($row_roles = $query_roles->fetch_assoc()) {
                          $selected = ($selectedRole == $row_roles['role']) ? " selected" : ""; // $selectedRole should be the selected role value
                          echo "
          <option value='" . $row_roles['role'] . "' " . $selected . ">" . $row_roles['role'] . "</option>
        ";
                        }
                        ?>
                      </select>
                    </div>
                  </form>
                </div>

              </div>
              <div class="box-body">
                <table id="example3" class="table table-bordered">
                  <thead>
                    <th class="hidden"></th>
                    <th>Date</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>ISBN</th>
                    <th>Title</th>
                  </thead>
                  <tbody>


                    <?php
                    while ($row = $query->fetch_assoc()) {
                      if ($row['status']) {
                        $status = '<span class="label label-danger">Borrowed</span>';
                      } else {
                        $status = '<span class="label label-success">Available</span>';
                      }
                      echo "
                         <tr>
                           <td class='hidden'></td>
                           <td>" . date('M d, Y', strtotime($row['date_return'])) . "</td>
                           <td>" . $row['stud'] . "</td>
                           <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                          <td>" . $row['isbn'] . "</td>
                          <td>" . $row['title'] . "</td>
                       </tr>
                       ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/return_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '#append', function(e) {
        e.preventDefault();
        $('#append-div').append(
          '<div class="form-group"><label for="" class="col-sm-3 control-label">ISBN</label><div class="col-sm-9"><input type="text" class="form-control" name="isbn[]"></div></div>'
        );
      });
    });

    $('#select_role').change(function() {
        var value = $(this).val();
        if (value == 0) {
          window.location = 'return.php';
        } else {
          window.location = 'return.php?role=' + value;
        }
      });
  </script>
</body>

</html>