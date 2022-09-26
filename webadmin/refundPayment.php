<?php include("header.php");
$title="";
$user_id="";
$reason="";
$added_on="";
$sku="";
$id="";
$amount="";
$class="";
$alert_class="";
$msg="";
if(isset($_GET['payment_id']) && $_GET['payment_id']!=""){
	$payment_id=get_safe_value($_GET['payment_id']);
    $res=mysqli_query($con,"select * from `refund_payment` where tran_id='$payment_id'");
    if(mysqli_num_rows($res)>0){
        // $row=mysqli_fetch_assoc($res);
        $class="d-none";
        $alert_class="danger";
        $msg="Refund already initiated";
    }
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    redirect("index");
}
if(isset($_POST['submit'])){
    $sql="select refundTrxID from refund_payment where tran_id='$payment_id' limit 1";
    $res=mysqli_query($con,$sql);
    if(mysqli_num_rows($res)>0){
        $msg="Refund already initiated";
    }else{
        $amount=get_safe_value($_POST['amount']);
        $sku=get_safe_value($_POST['sku']);
        $reason=get_safe_value($_POST['reason']);
        $time=time();
        $token=timeWiseTokenGeneartion();
        $sql="select bkash_credentials.id_token,bkash_online_payment.bkash_payment_id,bkash_online_payment.trxID from bkash_credentials,bkash_online_payment  where bkash_credentials.id='1' and bkash_online_payment.tran_id='$payment_id' limit 1";
        $rows=mysqli_fetch_assoc(mysqli_query($con,$sql));
        $refundData=array(
            'amount'=>$amount,
            'sku'=>$sku,
            'reason'=>$reason,
            'paymentID'=>$rows['bkash_payment_id'],
        );
        $data=refundPayment($token['id_token'],$rows['trxID'],$refundData);
        // prx($data);
        if(isset($data['statusCode']) && $data['statusCode']==0000){
            $statusMessage=$data['statusMessage'];
            $originalTrxID=$data['originalTrxID'];
            $refundTrxID=$data['refundTrxID'];
            $amount=$data['amount'];
            $transactionStatus=$data['transactionStatus'];
            $completedTime=time();
            $sql="select refundTrxID from refund_payment where originalTrxID='$originalTrxID' limit 1";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                $sql="update `refund_payment` set  `statusMessage`='$statusMessage',  `refundTrxID`='$refundTrxID', `transactionStatus`='$transactionStatus', `amount`='$amount', `completedTime`='$completedTime' where `originalTrxID`='$originalTrxID'";
                mysqli_query($con,$sql);
            }else{
                $sql="INSERT INTO `refund_payment` ( `user_id`, `tran_id`,`statusMessage`, `originalTrxID`, `refundTrxID`, `transactionStatus`, `amount`, `completedTime`) VALUES 
                                                        ( '$user_id', '$payment_id', '$statusMessage', '$originalTrxID', '$refundTrxID', '$transactionStatus', '$amount', '$completedTime')";
                mysqli_query($con,$sql);
            }
            if ($data['transactionStatus']=="Completed") {
                $msg="Refund Completed";
                $alert_class="success";
            }
        }else{
            pr($data);   
        }
    }
}

?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Refund Dashboard</h3>
        <ul>
            <li>
                <a href="index">Home</a>
            </li>
            <li>Refund Payment </li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- Add Notice Area Start Here -->
        <div class="col-4-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Create A Refund</h3>
                            <div align="center" class="alert alert-<?php echo $alert_class?> justify-content-center" role="alert">
                                <?php echo $msg?>
                            </div>
                        </div>
                    </div>
                    <form id="validate" class="new-added-form <?php echo $class?>" method="post">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Amount</label>
                                <input type="text" required placeholder="Enter amount" class="form-control" name="amount" id="amount"
                                    value="<?php echo $amount?>">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Title</label>
                                <input type="text" required placeholder="SKU" class="form-control" name="sku" id="sku"
                                    value="<?php echo $sku?>">
                            </div>
                            <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                <label>Refund Reason</label>
                                <textarea name="reason" id="editor" cols="30" rows="10"><?php echo $reason?></textarea>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <input type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark"
                                    name="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Notice Area End Here -->
    </div>
    <?php include("footer.php")?>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

    <script>
            ClassicEditor
                    .create( document.querySelector( '#editor' ) )
                    .then( editor => {
                            console.log( editor );
                    } )
                    .catch( error => {
                            console.error( error );
                    } );
    </script>