<?php include("header.php")?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Payment</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Payment Details</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Student Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <!-- <h3>About Me</h3> -->
                </div>
            </div>
            <div class="single-info-details">
                <!-- <div class="item-img">
                    <img src="img/figure/teacher.jpg" alt="teacher" height="150px" width="150px">
                </div> -->
                <div class="item-content">
                    <div class="info-table ">
                        <table class="table text-nowrap">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td class="font-medium text-dark-medium">Dhrubo Raj Roy</td>
                                </tr>
                                <tr>
                                    <td>Batch :</td>
                                    <td class="font-medium text-dark-medium">04</td>
                                </tr>
                                <tr>
                                    <td>Roll:</td>
                                    <td class="font-medium text-dark-medium">200130</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="col-xl-12 col-lg-12 col-12 ">
                            <center>
                                <p class="header_payment">Monthly Payment</p>
                            </center>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-12 form-group row" id="wrap">
                            <div class="col-xl-4 col-lg-4 col-12 form-group" id="my_box">
                                <label>Month *</label>
                                <select class="form-control disable_class" id="select_box_1"
                                    onchange="getMonthlyData('1')">
                                    <option value="">Please Select Month *</option>
                                    <?php
                                        $month_id=0;
                                        $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row['id']==$month_id){
                                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                            }else{
                                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }                                                        
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-12 form-group">
                                <label>Due amount</label>
                                <input type="number" value="0" id="number_1" class="form-control amount" disabled>
                            </div>
                            <input type="hidden" id="box_count" value="1">
                            <input type="hidden" id="total_amount" value="0">
                            <input style="margin-top: 20px;margin-bottom: 15px;" type="button" name="submit" id="submit"
                                value="Add More" class="btn-fill-lg font-normal text-light gradient-pastel-green"
                                onclick="add_more()">
                        </div>
                        <hr>
                        <div class="col-xl-12 col-lg-12 col-12 ">
                            <center>
                                <p class="header_payment">Fees</p>
                            </center>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-12 form-group row" id="wrap_fees">
                            <div class="col-xl-4 col-lg-4 col-12 form-group" id="my_box_fees">
                                <input type="hidden" id="fees_count" value="1">
                                <label>Fees *</label>
                                <select class="form-control form-control-lg" id="fee_select_box_1"
                                    onclick="getFeesData(1)">
                                    <option value="" selected disabled>Please Select fees *</option>
                                    <?php
                                        $fees_id=0;
                                        $res=mysqli_query($con,"SELECT * FROM `fees` where status='1'");
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row['id']==$fees_id){
                                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                            }else{
                                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }                                                        
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" id="fee_total" value="0">
                            <input type="hidden" id="fees_box_count" value="1">
                            <div class="col-xl-4 col-lg-4 col-12 form-group">
                                <label>Due amount</label>
                                <input type="email" value="0" class="form-control fee_amount" disabled
                                    id="fee_number_1">
                            </div>
                            <input type="hidden" id="box_count" value="1">

                            <input style="margin-top: 20px;margin-bottom: 15px;" type="button" name="submit" id="submit"
                                value="Add More" class="btn-fill-lg font-normal text-light gradient-pastel-green"
                                onclick="add_more_fees()">
                        </div>
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-8 form-group">
                            </div>
                            <div class="col-xl-4 col-lg-4 col-4 form-group">
                                <label>Total amount</label>
                                <input id="grant_total" value="0" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="modal-box">
                            <!-- Button trigger modal -->
                            <div class="row">
                                <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
                                <div class="col-xl-2 col-lg-2 col-12 form-group">
                                    <button type="button" class="modal-trigger" data-toggle="modal"
                                        data-target="#standard-modal">
                                        Save
                                    </button>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-12 form-group">
                                    <button type="button" class="btn-fill-lmd radius-4 text-light bg-violet-blue"
                                        onclick="reload()">
                                        Reload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Student Table Area End Here -->
    <?php include("footer.php")?>
    <script>
    jQuery("#submit").hide();


    function getFeesData(id) {
        var fee_id = jQuery("#fee_select_box_" + id).val();
        jQuery.ajax({
            type: "post",
            url: "./requests/getMonthlyFee.php",
            data: "fee_id=" + fee_id,
            success: function(result) {
                result = result.trim()
                // alert(result);
                jQuery("#fee_number_" + id).val(result);
                get_total();
                // jQuery("#submit").show();
            }
        });
    }


    function add_more_fees() {
        var option_value = '<?php
                                        $fees_id=0;
                                        $res=mysqli_query($con,"SELECT * FROM `fees` where status='1'");
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row['id']==$fees_id){
                                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                            }else{
                                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }                                                        
                                        }
                                    ?>';
        var fees_count = jQuery("#fees_count").val();
        fees_count++;
        jQuery("#fees_count").val(fees_count);
        jQuery("#wrap_fees").append('<div class="col-xl-12 col-lg-12 col-12 form-group row" id="fees_loop_' +
            fees_count +
            '"><div class="col-xl-6 col-lg-6 col-12 form-group"><label>Month *</label><select class="form-control" id="fee_select_box_' +
            fees_count + '" onclick="getFeesData(' + fees_count +
            ')"><option value="" selected disabled>Please Select Month *</option>' + option_value +
            '</select></div><div class="col-xl-4 col-lg-4 col-12 form-group"><label>Due amount</label><input type="email" value="0" id="fee_number_' +
            fees_count +
            '" class="form-control fee_amount" disabled></div><div class="col-xl-2 col-lg-2 col-2 form-group"><input style="margin-top: 20px;" type="button" name="submit" id="submit" value="Remove" class="btn-fill-lmd text-light radius-4 bg-gradient-gplus" onclick=remove_more_fees("' +
            fees_count + '")></div></div>'
        );
        get_total();
    }


    function remove_more_fees(fees_count) {
        jQuery("#fees_loop_" + fees_count).remove();
        var fees_count = jQuery("#fees_count").val();
        fees_count--;
        jQuery("#fees_count").val(fees_count);
    }

    function getMonthlyData(id) {
        var month_id = jQuery("#select_box_" + id).val();
        jQuery.ajax({
            type: "post",
            url: "./requests/getMonthlyFee.php",
            data: "month_id=" + month_id,
            success: function(result) {
                // alert(result);
                result = result.trim()
                jQuery("#number_" + id).val(result);
                get_total();
                jQuery("#submit").show();
            }
        });
    }

    function add_more() {
        var box_count = jQuery("#box_count").val();
        jQuery("#submit").hide();
        box_count++;
        // alert(box_count);
        jQuery("#box_count").val(box_count);
        jQuery("#wrap").append('<div class="col-xl-12 col-lg-12 col-12 form-group row" id="box_loop_' + box_count +
            '"><div class="col-xl-6 col-lg-6 col-12 form-group"><label>Month *</label><select id="select_box_' +
            box_count + '" onchange="getMonthlyData(' + box_count +
            ')" class="form-control disable_class"><option value="" selected disabled>Please Select Month *</option><?php
                                        $month_id=0;
                                        $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row['id']==$month_id){
                                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                            }else{
                                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                                            }                                                        
                                        }
                                    ?></select></div><div class="col-xl-4 col-lg-4 col-12 form-group"><label>Due amount</label><input type="email" id="number_' +
            box_count +
            '" value="0" class="form-control amount" disabled></div><div class="col-xl-2 col-lg-2 col-2 form-group"><input style="margin-top: 20px;" type="button" name="submit" id="submit" value="Remove" class="btn-fill-lmd text-light radius-4 bg-gradient-gplus"  onclick=remove_more("' +
            box_count + '")></div></div>'
        );
        get_total();
    }


    function remove_more(box_count) {
        jQuery("#box_loop_" + box_count).remove();
        var box_count = jQuery("#box_count").val();
        box_count--;
        jQuery("#box_count").val(box_count);
        get_total();
    }


    function get_total() {
        var total = 0;
        var amount = document.getElementsByClassName("amount");
        for (let i = 0; i < amount.length; i++) {
            var total = total + parseInt(amount[i].value);
        }
        var fee_total = $("#fee_total").val();
        var fee_amount = document.getElementsByClassName("fee_amount");
        for (let i = 0; i < fee_amount.length; i++) {
            var fee_total = parseInt(fee_total) + parseInt(fee_amount[i].value);
        }
        var grant_total = total + fee_total;
        document.getElementById("grant_total").value = grant_total;
    }

    function reload() {
        location.reload();
    }

    function disable() {
        var disable_class = document.getElementsByClassName("disable_class");
        for (let i = 0; i < disable_class.length; i++) {
            disable_class[i].setAttribute("disabled", "disabled");
            console.log();
        }
    }
    </script>