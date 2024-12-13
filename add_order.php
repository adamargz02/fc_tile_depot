<?php
  $page_title = 'Add Order';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);

  $all_orders = find_all('orders');
  $order_id = last_id('orders');
  $new_order_id = $order_id['id'] + 1;

  if (isset($_POST['add_order'])) {
    $customer = remove_junk($db->escape($_POST['customer']));
    $paymethod = remove_junk($db->escape($_POST['paymethod']));
    $notes = remove_junk($db->escape($_POST['notes']));
    $current_date = make_date();

    if (empty($errors)) {
      $sql  = "INSERT INTO orders (id, customer, paymethod, notes, date)";
      $sql .= " VALUES ('{$new_order_id}', '{$customer}', '{$paymethod}', '{$notes}', '{$current_date}')";
      if ($db->query($sql)) {
        $session->msg("s", "Successfully added order");
        redirect('add_sale_to_order.php?id=' . $new_order_id, false);
      } else {
        $session->msg("d", "Sorry, failed to insert.");
        redirect('add_order.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_order.php', false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <!--<span class="glyphicon glyphicon-th"></span>-->
        <span>Add New Order</span>
      </strong>
    </div>
    <div class="panel-body">
      <?php echo display_msg($msg); ?>
      <div class="col-md-6">
        <form method="post" action="add_order.php">
          <div class="form-group">
            <label for="customer">Customer Name</label>
            <input type="text" class="form-control" name="customer" placeholder="Enter customer name">
          </div>
          <div class="form-group">
            <label for="paymethod">Payment Method</label>
            <select class="form-control" name="paymethod">
              <option value="">Select Payment Method</option>
              <option value="Cash">Cash</option>
              <option value="Check">Check</option>
              <option value="Credit">Credit</option>
              <option value="Charge">Charge to Account</option>
            </select>
          </div>
          <div class="form-group">
            <label for="notes">Notes</label>
            <input type="text" class="form-control" name="notes" placeholder="Add any additional notes">
          </div>
          <div class="form-group text-right">
            <button type="submit" name="add_order" class="btn btn-primary">Start Order</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
