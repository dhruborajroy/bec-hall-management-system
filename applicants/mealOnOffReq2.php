
<?php 
include("header.php");
$meal_status="";
$meal_request_status="";
$uid=$_SESSION['USER_ID'];
if(isset($_POST['meal_request_status'])){
    $meal_request_status=get_safe_value($_POST['meal_request_status']);
    $sql="update `users` set `meal_request_status`='$meal_request_status', `meal_request_pending`='1' where users.id='$uid'";
    mysqli_query($con,$sql);
    $_SESSION['UPDATE']=true;
    redirect("mealOnOffReq2.php");
}
?>

<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Meal On/off request</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                Meal On/off Request
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
            <form  method="post">
                <div class="ui-alart-box row col-lg-12">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Current Meal status </label>
                            <?php
                            $res=mysqli_query($con,"Select meal_status from users where id='$uid'");
                            $row=mysqli_fetch_assoc($res);
                            if($row['meal_status']==1){
                                echo "On";
                            }elseif($row['meal_status']==0){
                                echo "Off";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    $last_date=cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                    $date=getdate();
                    if($date['hours']>=23){//11 PM

                    }else{
                    ?>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <?php
                                $res=mysqli_query($con,"Select meal_request_status,meal_request_pending,meal_status from users where id='$uid'");
                                $row=mysqli_fetch_assoc($res);
                                if($row['meal_request_pending']!=1){
                                    if($row['meal_status']==1){
                                        echo '<input type="hidden" value="0" name="meal_request_status">';
                                        if($row['meal_status']==1){
                                            echo '<button type="submit" class="btn-fill-md text-light bg-orange-red">Request to Meal off</button></li>';
                                        }else{
                                            echo '<button type="submit" class="btn-fill-md text-light bg-dark-pastel-green">Request to Meal on</button></li>';
                                        }
                                    }elseif($row['meal_status']==0){
                                        echo '<input type="hidden" value="1" name="meal_request_status">';
                                        if($row['meal_status']==0){
                                            echo '<button type="submit" class="btn-fill-md text-light bg-dark-pastel-green">Request to Meal on</button></li>';
                                        }else{
                                            echo '<button type="submit" class="btn-fill-md text-light bg-orange-red">Request to Meal off</button></li>';
                                        }
                                    }
                                }else{
                                    echo '<button class="btn-fill-md text-light bg-orange-red">Your meal request is in review. Pending admin approval</button></li>';
                                }
                                ?>
                            </select>
                        </div>
                    <?php }?>
                </div>
            </form>
        </div>
    </div>
    <?php include("footer.php")?>