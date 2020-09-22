<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

?>

<div class="container p-3">
    <div class="row">
        <div class="col-sm">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#monthly" data-toggle="tab" class="nav-link bg-primary text-light active">Month-wise Ledger</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#scheme" data-toggle="tab" class="nav-link">Scheme-wise Ledger</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#ledger" data-toggle="tab" class="nav-link">Month-wise Summary</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="monthly">
                    <h4 class="mb-3">Day-Wise Collection (Monthly Basis)</h4>
                    <div class="row">
                        <div class="col-sm">
                        <div class="table-responsive">
                           <table class="table table-hover text-center table-bordered table-sm">
							  <thead class="thead-dark">
							    <tr>
							      <th scope="col">Collection Date</th>
							      <th scope="col">Collected Amount</th>
							    </tr>
							  </thead>

							<?php

								$query = "	SELECT pay_date AS pay_date,
									  		SUM(pay_amount) AS pay_amount
									  		FROM cbl_ledger
									  		WHERE pay_amount > 0 AND renew_term = 1
									  		GROUP BY pay_date
									  		ORDER BY pay_date DESC";

							  	$result = mysqli_query($conn,$query);
								if (mysqli_num_rows($result) < 1){
								echo "<tr><td colspan='2'>No Collection yet!</td><tr>";

									} else {

								foreach ($result as $key => $data) : ?>

							  <tbody>
							    <tr>
							      <td>
							      	<a href="payment_list.php?query=<?php echo DailyCollMonth($data['pay_date']); ?>"><?php if($data['pay_date'] == date('Y-m-j')){ ?>
		      							<div class="text-danger"><strong>Today <?php echo date('j M'); ?></strong></div>
		    						<?php } else { ?>
		    							<div><?php echo date('j M',strtotime($data['pay_date'])); ?></div>
		    						<?php } ?></a>
							      </td>

							      <td>
							      	<strong><?php echo $data['pay_amount']; ?></strong>
							      </td>
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
                <div class="tab-pane" id="scheme">
                    <h4 class="mb-3">Day-Wise Collection (Monthly Basis)</h4>
                    <div class="row">
                        <div class="col-sm">
                        <div class="table-responsive">
                           <table class="table table-hover text-center table-bordered table-sm">
							  <thead class="thead-dark">
							    <tr>
							      <th scope="col">Collection Date</th>
							      <th scope="col">Collected Amount</th>
							    </tr>
							  </thead>

							<?php

								$query = "	SELECT pay_date AS pay_date,
									  		SUM(pay_amount) AS pay_amount
									  		FROM cbl_ledger
									  		WHERE pay_amount > 0 AND renew_term > 1
									  		GROUP BY pay_date
									  		ORDER BY pay_date DESC";

							  	$result = mysqli_query($conn,$query);
								if (mysqli_num_rows($result) < 1){
								echo "<tr><td colspan='2'>No Collection yet!</td><tr>";

									} else {

								foreach ($result as $key => $data) : ?>

							  <tbody>
							    <tr>
							      <td>
							      	<a href="payment_list.php?query=<?php echo DailyCollScheme($data['pay_date']); ?>"><?php if($data['pay_date'] == date('Y-m-j')){ ?>
		      							<div class="text-danger"><strong>Today <?php echo date('j M'); ?></strong></div>
		    						<?php } else { ?>
		    							<div><?php echo date('j M',strtotime($data['pay_date'])); ?></div>
		    						<?php } ?></a>
							      </td>

							      <td>
							      	<strong><?php echo $data['pay_amount']; ?></strong>
							      </td>
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
                	<h4 class="mb-3">Month-Wise Collections</h4>
                    <div class="row">
                        <div class="col-sm">
                        	<h1>Coming Soon!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'assets/footer.php'; ?>