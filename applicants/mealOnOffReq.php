
<?php 
include("header.php");
$meal_status="";
$guest_meal_request_status="";
if(isset($_POST['guest_meal_request_status'])){
    $guest_meal_request_status=get_safe_value($_POST['guest_meal_request_status']);
    $sql="update users set `guest_meal_request_status`='$guest_meal_request_status', `guest_meal_request_pending`='1' where users.id='1'";
    mysqli_query($con,$sql);
    $_SESSION['UPDATE']=true;
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
            <form  method="post">
                <div class="ui-alart-box row col-lg-12">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Current Meal status </label>
                            <?php
                            $res=mysqli_query($con,"Select guest_meal from users where id='1'");
                            $row=mysqli_fetch_assoc($res);
                            if($row['guest_meal']==1){
                                echo "On";
                            }elseif($row['guest_meal']==0){
                                echo "Off";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Guest Meal</label>
                            <?php
                            $res=mysqli_query($con,"Select guest_meal_request_status,guest_meal_request_pending,guest_meal from users where id='1'");
                            $row=mysqli_fetch_assoc($res);
                            if($row['guest_meal_request_pending']!=1){
                                    echo '<input type="hidden" value="0" name="guest_meal_request_status">';
                                    if($row['guest_meal']==1){
                                        echo '<button type="submit" class="btn-fill-md text-light bg-orange-red">Request to guest Meal off</button></li>';
                                    }else{
                                        echo '<button type="submit" class="btn-fill-md text-light bg-dark-pastel-green">Request to guest Meal on</button></li>';
                                    }
                                // }elseif($row['guest_meal_request_status']==0){
                                //     echo '<input type="hidden" value="1" name="guest_meal_request_status">';
                                //     if($row['guest_meal']==0){
                                //         echo '<button type="submit" class="btn-fill-md text-light bg-dark-pastel-green">Request toguest Meal on</button></li>';
                                //     }else{
                                //         echo '<button type="submit" class="btn-fill-md text-light bg-orange-red">Request toguest Meal off</button></li>';
                                //     }
                                // }
                            }else{
                                echo '<button class="btn-fill-md text-light bg-orange-red">Your guest meal request is in review. Pending admin approval</button></li>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php include("footer.php")?>