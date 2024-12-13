<?php
  $page_title = 'Add Stock';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);

  $selected_product = 0;
  if (isset($_GET['id'])) {
      $selected_product = (int)$_GET['id'];
  }

  $all_stock = find_all('stock');
  $all_products = find_all('products');
?>

<?php
 if (isset($_POST['add_stock'])) {
   $req_field = array('product_id', 'quantity');
   validate_fields($req_field);

   $product_id = remove_junk($db->escape($_POST['product_id']));
   $quantity = remove_junk($db->escape($_POST['quantity']));
   $comments = remove_junk($db->escape($_POST['comments']));
   $current_date = make_date();

   if (empty($errors)) {
      $sql  = "INSERT INTO stock (product_id, quantity, comments, date)";
      $sql .= " VALUES ('{$product_id}', '{$quantity}', '{$comments}', '{$current_date}')";
      $result = $db->query($sql);

      if ($result && $db->affected_rows() === 1) {
         increase_product_qty($quantity, $product_id);
         $session->msg("s", "Successfully added stock.");
         redirect('stock.php', false);
      } else {
         $session->msg("d", "Failed to insert stock.");
         redirect('add_stock.php', false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('add_stock.php', false);
   }
 }
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <!-- <span class="glyphicon glyphicon-th"></span> -->
        <span>Add Stock</span>
      </strong>
    </div>
    <div class="panel-body">
      <?php echo display_msg($msg); ?>
      <form method="post" action="" class="clearfix">
        <div class="form-group">
          <label for="product_id" class="control-label">Select Product</label>
          <select class="form-control" name="product_id">
            <option value="0">Select Product</option>
            <?php foreach ($all_products as $product): ?>
              <option value="<?php echo $product['id']; ?>" <?php echo ($selected_product == $product['id']) ? 'selected' : ''; ?>>
                <?php echo $product['name']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="quantity" class="control-label">Quantity</label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </span>
            <input type="number" class="form-control" name="quantity" placeholder="Enter product quantity">
          </div>
        </div>

        <div class="form-group">
          <label for="comments" class="control-label">Comments</label>
          <input type="text" class="form-control" name="comments" placeholder="Enter comments (optional)" value="<?php echo remove_junk(ucfirst($stock['comments'] ?? '')); ?>">
        </div>

        <div class="form-group text-right">
          <button type="submit" name="add_stock" class="btn btn-primary">Add Stock</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
