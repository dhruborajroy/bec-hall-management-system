<?php 
include("header.php");
   ?>
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Reports</h3>
                    <ul>
                        <li>
                            <a href="index">Home</a>
                        </li>
                        <li>Reports</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Class Routine Area Start Here -->
                <div class="row">
                    <div class="col-4-xxxl col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                            <h3>Generate Monthly Bill</h3>
                            </div>
                        </div>

                        <?php
                            // Limits based on your existing year range (2022 .. current)
                            $minMonth = "2022-01";
                            $maxMonth = date("Y-m");
                            // Defaults (current year-to-date)
                            $defaultStartMonth = date("Y") . "-01";
                            $defaultEndMonth = $maxMonth;
                        ?>

                        <form class="new-added-form" action="pdfreports/user_bill.php" method="get">
                            <div class="row">
                            <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                <label>Start month</label>
                                <input
                                type="month"
                                class="form-control"
                                name="start_date"
                                min="<?php echo $minMonth; ?>"
                                max="<?php echo $maxMonth; ?>"
                                value="<?php echo $defaultStartMonth; ?>"
                                pattern="[0-9]{4}-[0-9]{2}"
                                inputmode="numeric"
                                placeholder="YYYY-MM"
                                required
                                >
                            </div>

                            <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                <label>End month</label>
                                <input
                                type="month"
                                class="form-control"
                                name="end_date"
                                min="<?php echo $minMonth; ?>"
                                max="<?php echo $maxMonth; ?>"
                                value="<?php echo $defaultEndMonth; ?>"
                                pattern="[0-9]{4}-[0-9]{2}"
                                inputmode="numeric"
                                placeholder="YYYY-MM"
                                required
                                >
                            </div>

                            <div class="col-6 form-group mg-t-8">
                                <label></label>
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Generate</button>
                                <a href="pdfreports/user_bill.php" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Generate For This Year Bill</a>
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <div class="col-4-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Generate Monthly Bill</h3>
                                    </div>
                                </div>
                                <form class="new-added-form" action="pdfreports/monthly_bill.php">
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                            <label>Select Month</label>
                                            <select class="form-control select2" name="month_id">
                                                <?php
                                                    for ($month_id = 1; $month_id <= 12; $month_id++) {
                                                        $monthName = date("F", mktime(0, 0, 0, $month_id, 1)); // Get the month name
                                                        $formattedMonthId = sprintf("%02d", $month_id);
                                                        $currentMonth = date("m"); // Get the current month number
                                                        // Check if the current month matches the looped month
                                                        $selected = ($formattedMonthId == $currentMonth) ? "selected" : "";
                                                        echo "<option value=\"$formattedMonthId\" $selected>$monthName</option>";
                                                    }  
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                            <label>Year</label>
                                            <select class="select2" name="year" required>
                                                <?php
                                                $currentYear = date("Y"); // Get the current year
                                                for ($option_year = $currentYear; $option_year >= 2022; $option_year--) {
                                                    echo "<option value=\"$option_year\">$option_year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 form-group mg-t-8">
                                            <label></label>
                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-4-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Generate User List</h3>
                                    </div>
                                </div>
                                <form class="new-added-form" action="pdfreports/users.php">
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                            <label>Select Month</label>
                                            <select name="batch_id" id="batch_id" class="select2">
                                            <option value="">Select Batch</option>
                                            <option value="all">All Batch</option>
                                                <?php
                                                $batch_res=mysqli_query($con,"SELECT * FROM `batch` where status='1' order by numaric_value asc");
                                                while($batch_row=mysqli_fetch_assoc($batch_res)){
                                                    if($batch_row['id']==$batch){
                                                        echo "<option selected='selected' value=".$batch_row['id'].">".$batch_row['name']." Batch</option>";
                                                    }else{
                                                        echo "<option value=".$batch_row['id'].">".$batch_row['name']." Batch</option>";
                                                    }                                                        
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6 form-group mg-t-8">
                                            <label></label>
                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-4-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Generate Monthly Mill</h3>
                                    </div>
                                </div>
                                <form class="new-added-form" action="pdfreports/meal_status.php">
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                            <label>Select Month</label>
                                            <select name="month" class="select2">
                                                <?php
                                                for ($month_id = 1; $month_id <= 12; $month_id++) {
                                                    $monthName = date("F", mktime(0, 0, 0, $month_id, 1)); // Get the month name
                                                    $formattedMonthId = sprintf("%02d", $month_id);
                                                    $currentMonth = date("m"); // Get the current month number
                                                    // Check if the current month matches the looped month
                                                    $selected = ($formattedMonthId == $currentMonth) ? "selected" : "";
                                                    echo "<option value=\"$formattedMonthId\" $selected>$monthName</option>";
                                                }                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12-xxxl col-lg-3 col-12 form-group">
                                            <label>Year</label>
                                            <select name="year" class="select2">
                                                <?php
                                                $currentYear = date("Y"); // Get the current year
                                                for ($option_year = $currentYear; $option_year >= 2022; $option_year--) {
                                                    echo "<option value=\"$option_year\">$option_year</option>";
                                                }
                                                ?>               
                                            </select>
                                        </div>
                                        <div class="col-6 form-group mg-t-8">
                                            <label></label>
                                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- Class Routine Area End Here -->
<?php include("footer.php")?>
<script>
   function minus(id){
      var qty=jQuery('#qty_'+id).val();
      var main_price=jQuery('#fee_main_amount_'+id).val();
      if(qty>1){
         qty=parseInt(qty)-1;
      }
      jQuery('#qty_'+id).val(qty);
      price=(parseInt(qty)*parseFloat(main_price));
      jQuery('#fee_amount_'+id).val(price);
      get_fee_total(id);
   }
   function plus(id){
      var qty=jQuery('#qty_'+id).val();
      var main_price=jQuery('#fee_main_amount_'+id).val();
      qty=parseInt(qty)+1;
      jQuery('#qty_'+id).val(qty);
      price=(parseInt(qty)*parseFloat(main_price));
      jQuery('#fee_amount_'+id).val(price);
      get_fee_total(id);
   }
   // function plus(id){
      // var value=jQuery('#qty_'+id).val();
      // value=parseInt(value)+1;
      // jQuery('#qty_'+id).val(value);
      // var amount=jQuery('#fee_amount_'+id).val();
      // var final_amount=parseInt(value)*parseFloat(amount);
      // var amount=jQuery('#fee_amount_'+id).val(final_amount);
      // get_fee_total(id);
   // }
   function get_total(id) {
      if(document.getElementById("checkbox_"+id).checked==true){
         jQuery('#amount_'+id).addClass('active_amount');
         jQuery( '#amount_'+id ).prop( "disabled", false );
         jQuery( '#submit' ).prop( "disabled", false );
         jQuery( '#month_'+id ).prop( "disabled", false );
      }else if(document.getElementById("checkbox_"+id).checked==false){
         jQuery('#amount_'+id).removeClass('active_amount');
         jQuery( '#amount_'+id ).prop( "disabled", true );
         jQuery( '#month_'+id ).prop( "disabled", true );
      }
   	var total = 0;
   	var amount = document.getElementsByClassName("active_amount");
   	for (let i = 0; i < amount.length; i++) {
   		var total = total + parseFloat(amount[i].value);
   	}
      console.log(total);
      var grant_total=total;
      document.getElementById("grant_total").value = grant_total;
   }
   function get_fee_total(id){
      if(document.getElementById("fee_checkbox_"+id).checked==true){
         jQuery('#fee_amount_'+id).addClass('active_amount');
         jQuery( '#fee_amount_'+id ).prop( "disabled", false );
         jQuery( '#fee_id_'+id ).prop( "disabled", false );
         jQuery( '#submit' ).prop( "disabled", false );
         jQuery( '#month_'+id ).prop( "disabled", false );
      }else if(document.getElementById("fee_checkbox_"+id).checked==false){
         jQuery('#fee_amount_'+id).removeClass('active_amount');
         jQuery( '#fee_amount_'+id ).prop( "disabled", true );
         jQuery( '#fee_id_'+id ).prop( "disabled", true );
         jQuery( '#month_'+id ).prop( "disabled", true );
      }
   	var total = 0;
   	var amount = document.getElementsByClassName("active_amount");
   	for (let i = 0; i < amount.length; i++) {
   		var total = total + parseFloat(amount[i].value);
   	}
      console.log(total);
      var grant_total=total;
      document.getElementById("grant_total").value = grant_total.toFixed(2);
   }
</script>