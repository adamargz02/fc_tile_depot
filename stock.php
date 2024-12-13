<?php
  $page_title = 'All stock';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  
  $all_stock = find_all('stock');
  $all_products = find_all('products');
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="col-md-12"> <!-- Changed to col-md-12 for full width -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span>Inventory Log</span>
      </strong>
      <div class="pull-right">
        <a href="add_stock.php" class="btn btn-primary">Add Stock</a>
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive"> <!-- Added for responsive design -->
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Product</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Comments</th>
              <th class="text-center">Date</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_stock as $stock): ?>
              <tr>
                <td class="text-center">
                  <a href="view_product.php?id=<?php echo (int)$stock['product_id']; ?>">
                    <?php
                    foreach ($all_products as $product) {
                        if ($stock['product_id'] == $product['id']) {
                            echo $product['name'];
                        }
                    }
                    ?>
                  </a>
                </td>
                <td class="text-center">
                  <?php echo remove_junk(ucfirst($stock['quantity'])); ?>
                </td>
                <td class="text-center">
                  <?php echo remove_junk(ucfirst($stock['comments'])); ?>
                </td>
                <td class="text-center">
                  <?php echo remove_junk(ucfirst($stock['date'])); ?>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_stock.php?id=<?php echo (int)$stock['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_stock.php?id=<?php echo (int)$stock['id']; ?>" onClick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
