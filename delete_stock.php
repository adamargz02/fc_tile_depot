<?php
require_once('includes/load.php');
// Check if the user has permission to view this page
page_require_level(2);

// Check if the stock ID is valid
$d_stock = find_by_id('stock', (int)$_GET['id']);

if (!$d_stock) {
    $session->msg("d", "Missing stock id.");
    redirect('stock.php');
}

// Decrease inventory quantity for the product
if (decrease_product_qty($d_stock['quantity'], $d_stock['product_id'])) {
    // Try to delete stock entry after decreasing product quantity
    $delete_id = delete_by_id('stock', (int)$d_stock['id']);
    
    // Check if delete operation was successful
    if ($delete_id) {
        $session->msg("s", "Stock deleted successfully.");
    } else {
        $session->msg("d", "Stock deletion failed. Could not delete stock entry.");
    }
}

// Redirect back to stock page
redirect('stock.php');
