<?php
$page_title = 'Edit category';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(1);

// Fetch stock details
$stock = find_by_id('stock', (int)$_GET['id']);
if (!$stock) {
    $session->msg("d", "Missing stock id.");
    redirect('stock.php');
}

// Fetch associated product details
$product = find_by_id('products', (int)$stock['product_id']);

// Handle null product gracefully
if (!$product) {
    $product = [
        'name' => 'Unknown Product'
    ];
}
?>
<?php
if (isset($_POST['edit_stock'])) {
    $req_field = ['product_id', 'quantity'];
    validate_fields($req_field);
    $product_id = remove_junk($db->escape($_POST['product_id']));
    $quantity = remove_junk($db->escape($_POST['quantity']));

    // Check if the quantity has changed
    $s_qty_diff = 0;
    $decrease_quantity_flag = false;
    if ($quantity != $stock['quantity']) {
        $s_qty_diff = abs($quantity - $stock['quantity']);
        $decrease_quantity_flag = $quantity < $stock['quantity'];
    }

    $comments = remove_junk($db->escape($_POST['comments']));
    $current_date = make_date();

    if (empty($errors)) {
        $sql = "UPDATE stock SET";
        $sql .= " product_id='{$product_id}', quantity='{$quantity}', comments='{$comments}', date='{$current_date}'";
        $sql .= " WHERE id='{$stock['id']}'";

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            if ($s_qty_diff > 0) {
                if ($decrease_quantity_flag) {
                    decrease_product_qty($s_qty_diff, $product_id);
                } else {
                    increase_product_qty($s_qty_diff, $product_id);
                }
            }
            $session->msg("s", "Successfully updated");
            redirect('stock.php', false);
        } else {
            $session->msg("d", "Sorry! Failed");
            redirect('edit_stock.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_stock.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
          <!-- <span class="glyphicon glyphicon-th"></span> -->
           <span>Editing <?php echo remove_junk(ucfirst($stock['product_id'])); ?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="">
           <div class="form-group">
              <label for="name" class="control-label"><?php echo $product['name']; ?></label>
              <input type="hidden" class="form-control" name="product_id" value="<?php echo $stock['product_id']; ?>">
           </div>

           <div class="form-group">
               <div class="input-group">
                 <span class="input-group-addon">
                   <i class="glyphicon glyphicon-shopping-cart"></i>
                 </span>
                 <input type="number" class="form-control" name="quantity" value="<?php echo $stock['quantity']; ?>" placeholder="Product Quantity">
               </div>
           </div>

           <div class="form-group">
               <input type="text" class="form-control" name="comments" value="<?php echo remove_junk(ucfirst($stock['comments'])); ?>" placeholder="Notes">
           </div>

           <button type="submit" name="edit_stock" class="btn btn-primary">Update Inventory</button>
         </form>
       </div>
     </div>

     

   </div>
</div>

<?php include_once('layouts/footer.php'); ?>
