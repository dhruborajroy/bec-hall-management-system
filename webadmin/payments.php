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
                     <th>Name</th>
                     <th>Roll</th>
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
                     $sql = "SELECT monthly_bill.*,users.name,users.roll FROM monthly_bill,users where monthly_bill.user_id=users.id";
                     $res = mysqli_query($con, $sql);
                     $contingency_fee_per_month = CONTINGENCY_FEE;
                     $hall_fee = HALL_FEE;
                     $electricity_fee = ELECTRICITY_FEE;
                     
                     if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($roww = mysqli_fetch_assoc($res)) { 
                           $total_amount = $roww['amount'] + $contingency_fee_per_month + $hall_fee + $electricity_fee;
                     ?>
                  <tr>
                     <td><?php echo $roww['name'] ?></td>
                     <td><?php echo $roww['roll'] ?></td>
                     <td><?php echo date("F - y", strtotime($roww['year'] . "-" . $roww['month_id'])) ?></td>
                     <td><?php echo number_format($roww['amount'], 2) ?>
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