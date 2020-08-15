<?php require_once 'test.php'; ?>

          <div class="col-md-9">
          	<div class="container-fluid">


			    <form method="POST" action="<?php echo htmlspecialchars('renewal_process.php'); ?>">
			      <div class="card">
			          <ul class="list-group list-group-flush">
			            <li class="list-group-item"><span class="mr-2">Device No:</span>
			              <strong><?php echo $data['device_no']; ?></strong>
			            </li>
			            <li class="list-group-item"><span class="mr-2">Device MSO:</span>
			              <strong><?php echo $data['device_mso']; ?></strong>
			            </li>
			            <li class="list-group-item">
			              <input type="date" name="renew_date" class="form-control" required>
			            </li>
			            <li class="list-group-item">
			              <textarea name="note" placeholder="Notes" class="form-control"></textarea>
			            </li>
			            <li class="list-group-item">
			              <input type="hidden" name="invoice_no" value="<?php echo 'ALC'.date('Ymd').$data['user_id']; ?>">
			              <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
			              <input type="hidden" name="dev_id" value="<?php echo $dev_id; ?>">
			            </li>
			          </ul>
			      </div>
			  	</form>


			  	
			</div>
		</div>
	</div>

</section>

<?php require_once 'common/footer.php'; ?>