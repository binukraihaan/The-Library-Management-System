<?php include 'includes/session.php'; ?>
<?php
include 'includes/timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}
?>
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
          Dashboard
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM books";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Total Books</p>
              </div>
              <div class="icon">
                <i class="fa fa-book"></i>
              </div>
              <a href="book.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM users";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM returns WHERE date_return = '$today'";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Returned Today</p>
              </div>
              <div class="icon">
                <i class="fa fa-mail-reply"></i>
              </div>
              <a href="return.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <?php
                $sql = "SELECT * FROM borrow WHERE date_borrow = '$today'";
                $query = $conn->query($sql);

                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Issued Today</p>
              </div>
              <div class="icon">
                <i class="fa fa-mail-forward"></i>
              </div>
              <a href="borrow.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Monthly Transaction Report</h3>
                <div class="box-tools pull-right">


                  <form class="form-inline">
                    <div class="form-group">
                      <label>Select Year: </label>
                      <select class="form-control input-sm" id="select_year">
                        <?php
                        for ($i = 2015; $i <= 2065; $i++) {
                          $selected = ($i == $year) ? 'selected' : '';
                          echo "
              <option value='" . $i . "' " . $selected . ">" . $i . "</option>
            ";
                        }
                        ?>
                      </select>
                    </div>
                  </form>




                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <br>
                  <!-- <div id="legend" class="text-center"></div> -->
                  <canvas id="barChart" style="height:350px"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- right col -->

    </div>
    <?php include 'includes/footer.php'; ?>

  </div>
  <!-- ./wrapper -->

  <?php include 'includes/scripts.php'; ?>

  <script>
    $(function() {
      $('#select_year').change(function() {
        window.location.href = 'home.php?year=' + $(this).val();
      });
    });

    // Fetch data from server-side script
    function fetchData(year) {
      return new Promise((resolve, reject) => {
        // Make an AJAX request to fetch data
        $.ajax({
          url: 'borrow_return_chart_data.php', // Provide the correct URL to your server-side script
          method: 'GET',
          data: {
            year: year
          },
          success: function(response) {
            resolve(response); // Resolve with the fetched data
          },
          error: function(xhr, status, error) {
            reject(error); // Reject with the error message
          }
        });
      });
    }

    // Function to update chart with new data
    async function updateChart(year) {
      try {
        const data = await fetchData(year);
        const chartData = {
          labels: data.months,
          datasets: [{
              label: 'Issued',
              backgroundColor: 'rgba(221, 75, 57, 1)',
              borderColor: 'rgba(221, 75, 57, 1)',
              data: data.borrow
            },
            {
              label: 'Returned',
              backgroundColor: 'rgba(243, 156, 18, 1)',
              borderColor: 'rgba(243, 156, 18, 1)',
              data: data.return
            }
          ]
        };

        // Get the canvas element
        const ctx = document.getElementById('barChart').getContext('2d');

        // Check if window.barChart is defined and an instance of Chart
        if (window.barChart && window.barChart instanceof Chart) {
          // Update chart data
          window.barChart.data = chartData;
          window.barChart.update();
        } else {
          // Create new chart instance
          window.barChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          });
        }

        // Update legend
        // document.getElementById('legend').innerHTML = window.barChart.generateLegend();
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }

    // Call updateChart function initially with default year
    updateChart(<?php echo $year; ?>);
  </script>


</body>

</html>