</div>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline"><strong>Version</strong> 2.0 (Muffin)</div>
      <strong>Copyright &copy; 2019-<?php echo date('Y') ?> Endeavour Technologies Pvt Ltd.</strong> All rights reserved.
    </footer>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="assets/scripts/jquery.min.js"></script>
    <script src="assets/scripts/jquery-ui.js"></script>
    <script src="assets/scripts/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/scripts/adminlte.min.js"></script>
    <script src="assets/scripts/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts/maskedinput.js"></script>
    <script src="assets/scripts/toastr.min.js"></script>
    <script src="assets/scripts/script.js"></script>

<!-- Notification LEDs -->
  <script type="text/javascript">
    <?php 
      if(isset($_GET['msg'], $_GET['code'])): ?>
        toastr["<?php echo $_GET['code']; ?>"]("<?php echo $_GET['msg']; ?>")
    <?php endif ?>
  </script>
<!-- Notification LEDs -->

</body>
</html>