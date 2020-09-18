                        	<table class="table table-hover table-bordered table-sm">
							  <thead class="thead-dark">
							    <tr>
							      <th scope="col">Month</th>
							      <th scope="col">Total Collection</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<tr>
							      <td>January, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('January'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>February, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('February'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>March, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('March'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>April, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('April'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>May, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('May'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>June, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('June'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>July, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('July'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>August, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('August'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>September, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('September'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>October, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('October'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>November, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('November'); ?></strong></td>
							    </tr>
							    <tr>
							      <td>December, <?php echo date('Y'); ?></td>
							      <td><strong><?php echo sumMonthlyPayment('December'); ?></strong></td>
							    </tr>
							  </tbody>
							</table>