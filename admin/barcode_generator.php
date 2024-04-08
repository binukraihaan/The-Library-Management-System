<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/conn.php'; ?>

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
                    Barcode Generator
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">Barcode Generator</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_SESSION['error'])) {
                    echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
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

                                <!-- <input type="text" class="form-control input-lg" id="input" placeholder="Search for Student ID or Student Name" autofocus> -->
                                <select class="form-control selectpicker input-lg" id="input" onchange="getUserData()">
                                    <option value="">Select the user</option>
                                    <?php
                                    $sql = "SELECT user_id, firstname, lastname FROM users";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['user_id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . " | " . $row['user_id'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No students found</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-6 text-center">
                                        <svg style="display:none" id="barcode"></svg>
                                    </div>
                                    <div class="col-xs-6">
                                        <form class="form-horizontal" method="POST" action="">
                                            <input type="hidden" class="bookid" name="id">
                                            <div class="form-group">
                                                <label for="edit_isbn" class="col-sm-3 control-label">User ID : </label>

                                                <div class="col-sm-9">
                                                    <!-- <input type="text" class="form-control" id="edit_id" name="id" style="border: none;"> -->
                                                    <p id="edit_id" style="margin-top:7px;"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_title" class="col-sm-3 control-label">First Name : </label>

                                                <div class="col-sm-9">
                                                    <input type="text" name="fname" id="fname" class="form-control" style="border: none;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_title" class="col-sm-3 control-label">Last Name : </label>

                                                <div class="col-sm-9">
                                                    <input type="text" name="lname" id="lname" class="form-control" style="border: none;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_title" class="col-sm-3 control-label">Class : </label>

                                                <div class="col-sm-9">
                                                    <input type="text" name="course" id="course" class="form-control" style="border: none;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_title" class="col-sm-3 control-label">Role : </label>

                                                <div class="col-sm-9">
                                                    <input type="text" name="role" id="role" class="form-control" style="border: none;">
                                                </div>
                                            </div>
                                            <button class="btn btn-info btn-flat pull-right" onclick="downloadBarcode()"><i class="fa fa-download" aria-hidden="true"></i> Download Barcode</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
        <?php include 'includes/footer.php'; ?>

    </div>


    <?php include 'includes/scripts.php'; ?>

    <script>
        function getUserData() {
            var selectedUserId = $('#input').val();

            $.ajax({
                url: 'get_user_data.php',
                method: 'POST',
                data: {
                    user_id: selectedUserId
                },
                dataType: 'json',
                success: function(response) {
                    $('#edit_id').html(response.user_id)
                    $('#fname').val(response.firstname);
                    $('#lname').val(response.lastname);
                    $('#course').val(response.code);
                    $('#role').val(response.role);

                    generateBarcode();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    </script>

</body>

</html>