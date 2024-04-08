<?php include 'includes/session.php'; ?>
<?php
$where = '';
if (isset($_GET['category'])) {
	$catid = $_GET['category'];
	$where = 'WHERE category_id = ' . $catid;
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">

				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<?php
							if (isset($_SESSION['error'])) {
								echo "
	        					<div class='alert alert-danger'>
	        						" . $_SESSION['error'] . "
	        					</div>
	        				";
								unset($_SESSION['error']);
							}
							?>
							<div class="box">
								<div class="box-header with-border">
									<div class="input-group">
										<input type="text" class="form-control input-lg" id="searchBox" placeholder="Search for ISBN, Title or Author" autofocus>
										<span class="input-group-btn">
											<button type="button" class="btn btn-primary btn-flat btn-lg"><i class="fa fa-search"></i> </button>
										</span>
									</div>
								</div>
								<div class="box-body">
									<div class="input-group col-sm-5">
										<span class="input-group-addon">Category:</span>
										<select class="form-control" id="catlist">
											<option value=0>ALL</option>
											<?php
											$sql = "SELECT * FROM category";
											$query = $conn->query($sql);
											while ($catrow = $query->fetch_assoc()) {
												$selected = ($catid == $catrow['id']) ? " selected" : "";
												echo "
				                				<option value='" . $catrow['id'] . "' " . $selected . ">" . $catrow['name'] . "</option>
				                			";
											}
											?>
										</select>
									</div>
									<table class="table table-bordered table-striped" id="booklist">
										<thead>
											<th>ISBN</th>
											<th>Title</th>
											<th>Location</th>
											<th>Author</th>
											<th>Status</th>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM books $where";

											$query = $conn->query($sql);
											while ($row = $query->fetch_assoc()) {
												$status = ($row['status'] == 0) ? '<span class="label label-success">Available</span>' : '<span class="label label-danger">Borrowed</span>';
												// $borrower = ($row['status'] == 0 && $row['borrower_name'] != '') ? $row['borrower_name'] : 'N/A';
												echo "
			        						<tr>
			        							
			        							<td>" . $row['isbn'] . "</td>
			        							<td>" . $row['title'] . "</td>
			        							<td class='text-center'><b>" . $row['room'] . " . " . $row['shelf'] . " . " . $row['row'] ."</b></td>
			        							<td>" . $row['author'] . "</td>
			        							<td>" . $status . "</td>
												
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
		</div>

		<?php include 'includes/footer.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
	<script>
		$(function() {
			$('#catlist').on('change', function() {
				if ($(this).val() == 0) {
					window.location = 'index.php';
				} else {
					window.location = 'index.php?category=' + $(this).val();
				}

			});
		});
	</script>
</body>

</html>