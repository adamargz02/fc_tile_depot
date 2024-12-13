<?php
$page_title = 'Monthly Sales';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

$year = date('Y');
$sales = monthlySales($year);
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span>Sales Report</span>
        </strong>
        <!-- Dropdown for Sales Reports -->
        <form method="get" class="pull-right" style="margin: 30; height: 30px">
          <select name="report" id="report" class="form-control" onchange="redirectToPage(this.value)">
            <option value="">Select Report</option>
            <option value="sales_report">Sales by Dates</option>
            <option value="daily_sales">Daily Sales</option>
            <option value="monthly_sales">Monthly Sales</option>
          </select>
        </form>
      </div>
      <div class="panel-body">
        <?php
          // Check if a report is selected
          $report = $_GET['report'] ?? 'monthly_sales';

          // Include the appropriate table based on the selected report
          switch ($report) {
            case 'sales_report':
              include 'sales_report.php';
              break;

            case 'daily_sales':
              include 'daily_sales.php';
              break;

            case 'monthly_sales':
            default:
              include 'monthly_sales_table.php';
              break;
          }
        ?>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Redirection -->
<script>
  function redirectToPage(report) {
    if (report) {
      window.location.href = "?report=" + report;
    }
  }
</script>

<?php include_once('layouts/footer.php'); ?>
