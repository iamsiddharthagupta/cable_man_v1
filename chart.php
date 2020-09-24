  $result = $user->chart_data_fetch();

<div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Device Overviews</h3>
          </div>
          <div class="card-body">
            <div id="piechart"></div>
          </div>
        </div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['MSO', 'Device Count'],

      <?php

          while($row = mysqli_fetch_array($result)){  
              echo "['".$row["device_mso"]."', ".$row["devices"]."],";  
            }

      ?>

    ]);

    var options = {
      title: 'MSO Wise Devices'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>