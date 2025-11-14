<?php 
include("header.php");

$user_id = $_SESSION['USER_ID'];



?>
<div class="dashboard-content-one">
<div class="breadcrumbs-area">
   <h3>Payment</h3>
   <ul>
      <li><a href="index.php">Home</a></li>
      <li>Payment Details</li>
   </ul>
</div>
<div class="card height-auto" >
<div class="card-body">
<form method="POST">
   <div class="single-info-details">
      <div class="item-content">
         <div class="info-table ">
            <table class="table table-hover"  style="width: 100%;">
               <thead class="thead-dark">
                  <tr>
                     <th>Month</th>
                     <th>Due (৳)</th>
                     <th>Hall Fee (৳)</th>
                     <th>Electricity (৳)</th>
                     <th>Contingency (৳)</th>
                     <th><strong>Total (৳)</strong></th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     $sql = "SELECT * FROM monthly_bill WHERE user_id='$user_id' ";
                     $res = mysqli_query($con, $sql);
                     $contingency_fee_per_month = 300;
                     $hall_fee = 10;
                     $electricity_fee = 100;
                     
                     if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($roww = mysqli_fetch_assoc($res)) { 
                           $total_amount = $roww['amount'] + $contingency_fee_per_month + $hall_fee + $electricity_fee;
                     ?>
                  <tr>
                     <td><?php echo date("F - y", strtotime($roww['year'] . "-" . $roww['month_id'])) ?></td>
                     <td><input disabled type="hidden" id="month_<?php echo $i ?>" name="month_id[]" value="<?php echo $roww['month_id'] ?>"> 
                        <input disabled type="hidden" name="monthly_amount[]" value="<?php echo $roww['amount'] ?>" id="amount_<?php echo $i ?>" class="amount"> 
                        <?php echo number_format($roww['amount'], 2) ?>
                     </td>
                     <td><?php echo number_format($hall_fee, 2) ?></td>
                     <td><?php echo number_format($electricity_fee, 2) ?></td>
                     <td><?php echo number_format($contingency_fee_per_month, 2) ?></td>
                     <td><strong><?php echo number_format($total_amount, 2) ?></strong></td>
                        <td>
                        <?php if ($roww['paid_status'] == '1') { ?>
                            <button type="button" 
                                class="btn-fill-lmd text-light shadow-dodger-blue" 
                                style="padding: 3px 5px; background:green;">
                                Paid
                            </button>
                        <?php } else { ?>
                            <button type="button" 
                                class="btn-fill-lmd text-light shadow-dodger-blue" 
                                style="padding: 3px 5px; background:red;">
                                Unpaid
                            </button>
                        <?php } ?>
                    </td>

                    </tr>
                  <?php 
                     $i++; 
                     } 
                     } else { ?>
                  <tr>
                     <td colspan="8" class="text-center">No due found</td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </div>
</form>
</div>
<?php include("footer.php")?>