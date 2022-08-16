<?php include("header.php");
$meal_status="";
if(isset($_POST['submit'])){
    $status=get_safe_value($_POST['status']);
    // }else{
    //     redirect('index.php');
    // }
}
$sql="select meal_status from users where roll='200129'";
$res=mysqli_query($con,$sql);
if (mysqli_num_rows($res)>0) {
    $row=mysqli_fetch_assoc($res);
}
$meal_status=$row['meal_status'];
?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Meal on/off</h3>
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
            <div class="ui-alart-box  row col-lg-12">
                <div class="icon-color-alart col-lg-6">
                    <div class="alert icon-alart bg-pink2" role="alert">
                        <i class="fas fa-times bg-pink3"></i>
                        Your Meal is <?php 
                                    $data=[
                                        0=>'Off',
                                        1=>'On',
                                    ];
                                    foreach ($data as $key => $value) {
                                        if(intval($key)==intval($meal_status)){
                                            echo $value;
                                        }
                                    }
                                    ?>. 
                    </div>
                </div>
                <div class="ui-btn-wrap col-lg-6">
                    <ul>
                        <li><button type="button" class="btn-fill-md text-light bg-dark-pastel-green">Request Meal on</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php")?>