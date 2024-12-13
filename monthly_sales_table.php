<?php
  $year = date('Y');
  $sales = monthlySales($year);

  // Calculate total sales for the month
  $total_sales = 0;
  foreach ($sales as $sale) {
      $total_sales += $sale['total_saleing_price'];
  }
?>

<table class="table table-bordered table-striped"> MONTHLY SALES
  <thead>
    <tr>
      <th class="text-center" style="width: 50px;">#</th>
      <th> Product name </th>
      <th class="text-center" style="width: 15%;"> Quantity sold</th>
      <th class="text-center" style="width: 15%;"> Total </th>
      <th class="text-center" style="width: 15%;"> Date </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($sales as $sale): ?>
    <tr>
      <td class="text-center"><?php echo count_id(); ?></td>
      <td><?php echo remove_junk($sale['name']); ?></td>
      <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
      <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
      <td class="text-center"><?php echo $sale['date']; ?></td>
    </tr>
    <?php endforeach; ?>
    <!-- Add a total row -->
    <tr>
      <td class="text-left" colspan="3"><strong>TOTAL MONTHLY SALES:</strong></td>
      <td class="text-center"><strong><?php echo number_format($total_sales, 2); ?></strong></td>
      <td class="text-center"></td>
    </tr>
  </tbody>
</table>
