<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>

<?php
function isLinkActive($link)
{
    return (strpos($_SERVER['REQUEST_URI'], $link) !== false) ? 'active' : '';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-success" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand text-light" href="index.php">ERP System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link <?php echo isLinkActive('index.php'); ?>" aria-current="page" href="index.php">Customer</a>
        <a class="nav-link <?php echo isLinkActive('registerItem.php'); ?>" href="registerItem.php">Items</a>
        <a class="nav-link <?php echo isLinkActive('reports.php'); ?>" href="reports.php">Invoice Report</a>
        <a class="nav-link <?php echo isLinkActive('invoiceItemReport.php'); ?>" href="invoiceItemReport.php">Invoice Item Report</a>
        <a class="nav-link <?php echo isLinkActive('itemReport.php'); ?>" href="itemReport.php">Item Report</a>
      </div>
    </div>
  </div>
</nav>