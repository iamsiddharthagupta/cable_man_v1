<?php

	session_start();

	$curr_user = $_SESSION['curr_user'];
	$user_level = $_SESSION['user_level'];

	$page = 'collection_book.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$result = $security->session($curr_user, $user_level);

?>

<div class="container p-2">
    <div class="row">
        <div class="col-sm">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#monthly" data-toggle="tab" class="nav-link bg-primary text-light active">Day-wise Summary</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#ledger" data-toggle="tab" class="nav-link">Month-wise Summary</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="monthly">
                    <h5 class="mb-3">Day Collection Summary</h5>
                    <div class="row">
                        <div class="col-sm">
                        <div class="card-body table-responsive p-0" style="height: 500px;">
							<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
							  <thead class="thead-light">
							    <tr>
							      <th scope="col">Collection Date</th>
							      <th scope="col">Collected Amount</th>
							    </tr>
							  </thead>

							<?php

								$result = $user->day_collection_summary();

								if (mysqli_num_rows($result) < 1){
								echo "<tr><td colspan='2'>No Collection yet!</td><tr>";

									} else {

								foreach ($result as $key => $row) : ?>

							  <tbody>
							    <tr>
							      <td>
							      	<?php if($row['pay_date'] == date('Y-m-j')){ ?>
		      							<div class="text-danger"><strong>Today <?php echo date('j M'); ?></strong></div>
		    						<?php } else { ?>
		    							<div><?php echo date('j M',strtotime($row['pay_date'])); ?></div>
		    						<?php } ?>
							      </td>

							      <td><strong><?php echo $row['pay_amount']; ?></strong></td>

							    </tr>
							  </tbody>

							<?php
							  	endforeach;
							  }
							?>
							</table>
						</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="ledger">
                	<h5 class="mb-3">Month Collection Summary</h5>
                                        <div class="row">
                        <div class="col-sm">
                        <div class="card-body table-responsive p-0" style="height: 500px;">
							<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
							  <thead class="thead-light">
							    <tr>
							      <th scope="col">Month</th>
							      <th scope="col">Amount</th>
							    </tr>
							  </thead>

							<?php

								$result = $user->month_collection_summary();

								if (mysqli_num_rows($result) < 1){
								echo "<tr><td colspan='2'>No Collection yet!</td><tr>";

									} else {

								foreach ($result as $key => $row) : ?>

							  <tbody>
							    <tr>
							      <td><?php echo $row['month']; ?></td>

							      <td><strong><?php echo $row['pay_amount']; ?></strong></td>

							    </tr>
							  </tbody>

							<?php
							  	endforeach;
							  }
							?>
							</table>
						</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>