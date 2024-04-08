<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
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
        List Of Staff
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Users</li>
        <li class="active">List Of Staff</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Add New Staff</a>

              <div class="box-tools pull-right">
                  <form class="form-inline">
                    <div class="form-group">
                      <label>Select Class: </label>&nbsp;
                      <select class="form-control input-sm" id="select_course">
                        <option value="0">ALL</option>
                        <?php
                        $sql_courses = "SELECT * FROM course"; // Assuming 'course' table stores courses
                        $query_courses = $conn->query($sql_courses);
                        while ($row_course = $query_courses->fetch_assoc()) {
                          $selected = ($selectedCourse == $row_course['id']) ? " selected" : ""; // $selectedCourse should be the selected course value
                          echo "
          <option value='" . $row_course['id'] . "' " . $selected . ">" . $row_course['code'] . "</option>
        ";
                        }
                        ?>
                      </select>
                    </div>&nbsp;
                    <button type="button" class="btn btn-default btn-flat" onclick="pageReload()"><i class="fa fa-refresh"></i></button>
                  </form>
                </div>

            </div>
            <div class="box-body">

            <?php
                $selectedCourse = isset($_GET['course']) ? $_GET['course'] : '0';  // Assuming you are using GET method to pass selected course value
                $where = "";
                if ($selectedCourse && $selectedCourse != '0') {
                  $where = " WHERE teachers.course_id = '$selectedCourse'";
                }

                $sql = "SELECT *, teachers.id AS tecid FROM teachers 
                LEFT JOIN course ON course.id = teachers.course_id
                $where";

                $query = $conn->query($sql);
                ?>

              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Responsible Course</th>
                  <th>User Profile</th>
                  <th>Teacher ID</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Actions</th>
                </thead>
                <tbody>
                  <?php
                    // $sql = "SELECT *, teachers.id AS tecid FROM teachers LEFT JOIN course ON course.id=teachers.course_id";
                    // $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $photo = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                      echo "
                        <tr>
                          <td>".$row['code']."</td>
                          <td>
                            <img src='".$photo."' width='30px' height='30px'>
                            <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='".$row['tecid']."'><span class='fa fa-edit'></span></a>
                          </td>
                          <td>".$row['teacher_id']."</td>
                          <td>".$row['firstname']."</td>
                          <td>".$row['lastname']."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['tecid']."'><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['tecid']."'><i class='fa fa-trash'></i> Delete</button>
                          </td>
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
  <?php include 'includes/teacher_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'teacher_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.tecid').val(response.tecid);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#selcourse').val(response.course_id);
      $('#selcourse').html(response.code);
      $('.del_tec').html(response.firstname+' '+response.lastname);
    }
  });
}

$('#select_course').change(function(event) {
      // event.preventDefault();
      var selectedCourse = document.getElementById("select_course").value;
      if (selectedCourse === "0") {
        console.log("Selected Course: ALL");
        // If "ALL" is selected, remove the course parameter from the URL
        window.location = "teacher.php";
      } else {
        console.log("Selected Course: " + selectedCourse);
        // If a specific course is selected, include it in the URL
        window.location = "teacher.php?course=" + selectedCourse;
      }
    });


    function pageReload(){
      window.location.replace("teacher.php");
    }
</script>
</body>
</html>
