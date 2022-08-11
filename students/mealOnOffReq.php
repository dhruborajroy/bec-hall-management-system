<?php 
include("header.php");
$meal_status="";
if(isset($_POST['submit'])){
    $status=get_safe_value($_POST['status']);
    // }else{
    //     redirect('index.php');
    // }
}

?>
<!-- <div class="col-sm-3">
    <select id="final_city_arrival" name="final_city_arrival" class="form-control" required="true" onchange="showcityother(this.value);">
        <option value="">Select</option>
        <option value="1">Delhi</option>
        <option value="2">Bengaluru</option>
        <option value="3">Kolkata</option>
        <option value="4">Chennai</option>
        <option value="5">Mumbai</option>
        <option value="6">Hyderabad</option>
        <option value="7">Other</option>		    	
    </select>
</div>
<div class="col-sm-3  city_other">
    <input type="text" name="city_other" id="city_other" placeholder="Other City" class="form-control">
</div> -->
<script>
function showcityother(id){
    console.log(id);
    var v = $('#'+ id).val();
    if(v==7)
    {
        $('.city_other').addClass("in");
    }
    else
    {
        $('.city_other').removeClass("in");
    }
}
    
</script>

<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Meal On/off request</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                Meal On off Request
            </li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Button Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1 mg-b-25">
                <div class="item-title">
                    <h3>Meal On off Request</h3>
                </div>
            </div>
            <form action="" method="post">
                <div class="ui-alart-box row col-lg-12">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Dept *</label>
                        <select class="form-control select2" name="meal_status">
                            <option>Select Depertment</option>
                            <?php
                            $res=mysqli_query($con,"Select meal_status from users where id=".$_SESSION['USER_ID']);
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['meal_status']==$meal_status){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['meal_status']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['meal_status']."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Meal Status *</label>
                        <select class="select2" name="status">
                            <option readonly="readonly">Please Select status *</option>
                            <?php
                            $data=[
                                'name'=>[
                                    'Off',
                                    'On',
                                ]
                            ];
                            // print_r($data['name'][0]);
                            $count=count($data['name']);
                            for($i=0;$i<$count;$i++){
                                if($data['name'][$i]==intval($meal_status)){
                                    echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }else{
                                    echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }                                                        
                            }
                        ?>
                        </select>
                    </div>
                    <div class="ui-btn-wrap col-lg-6">
                        <ul>
                            <input type="hidden" name="status" value="1">
                            <!-- <li><button type="button" class="btn-fill-md text-light bg-dark-pastel-green">Meal On/Request Meal Off</button></li> -->
                            <li><button type="submit" name="submit" class="btn-fill-md radius-4 text-light bg-orange-red">Submit</button></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("footer.php")?>