<?php include("header.php");
$title="";
$user_id="";
$details="";
$added_on="";
$reference="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from `notice` where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $title=$row['title'];
        $details=$row['details'];
        $added_on=$row['added_on'];
        $reference=$row['reference'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
	$title=get_safe_value($_POST['title']);
	$reference=get_safe_value($_POST['reference']);
	$details=$_POST['details'];
    $user_id=$_SESSION['ADMIN_ID'];
    $added_on=time();
   if($id==''){
        $id=uniqid();
        $sql="INSERT INTO `notice` (`id`, `title`, `details`,`reference`, `added_on`,`updated_on`, `user_id`, `status`) VALUES 
                                    ('$id', '$title', '$details','$reference', '$added_on', '','$user_id', '1')";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $updated_on=time();
        $sql="update `notice` set  `title`='$title', `details`='$details',`reference`='$reference',`updated_on`='$updated_on' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
    redirect('./notices');
}

?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Notice board</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Notices </li>
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
                            <h3>Create A Notice</h3>
                        </div>
                    </div>
                    <form id="validate" class="new-added-form" method="post">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Reference No</label>
                                <input type="text" required placeholder="" class="form-control" name="reference" id="reference"
                                    value="<?php echo $reference?>">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Title</label>
                                <input type="text" required placeholder="" class="form-control" name="title" id="title"
                                    value="<?php echo $title?>">
                            </div>
                            <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                <label>Details</label>
                                <textarea name="details" id="editor" cols="30" rows="10"><?php echo $details?></textarea>
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