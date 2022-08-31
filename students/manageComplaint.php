<?php 
include("header.php");
$content="";
$category_id="";
$added_on="";
$complaint="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from `complaint_box` where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $content=$row['content'];
        $category_id=$row['category_id'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
    $content=get_safe_value($_POST['content']);
    $category_id=get_safe_value($_POST['category_id']);
    $user_id=$_SESSION['USER_ID'];
    $time=time();
   if($id==''){
        $sql="INSERT INTO `complaint_box`(`content`, `user_id`, `category_id`, `added_on`,`updated_on`,`status`) VALUES 
                                            ('$content','$user_id','$category_id','$time','','1')";
        $query=mysqli_query($con,$sql);
        if($query==1){
            $_SESSION['INSERT']="Data Inserted Successfully";
        }
    }else{
        $sql="update `complaint_box` set  `content`='$content', `category_id`='$category_id', `updated_on`='$time' where id='$id'";
        $query=mysqli_query($con,$sql);
        if($query==1){
            $_SESSION['UPDATE']="Data Updated Successfully";;
        }
    }
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
                            <h3>Create A Complaint</h3>
                        </div>
                    </div>
                    <form id="validate" class="new-added-form" method="post">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-12 form-group">
                                <label>Category *</label>
                                <select class="select2" name="category_id">
                                    <option>Select Category</option>
                                    <?php
                                    $res=mysqli_query($con,"SELECT * FROM `depts` where status='1'");
                                    while($row=mysqli_fetch_assoc($res)){
                                        if($row['id']==$category_id){
                                            echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                        }else{
                                            echo "<option value=".$row['id'].">".$row['name']."</option>";
                                        }                                                        
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                <label>Complaint</label>
                                <textarea name="content" id="editor" cols="30" rows="10"><?php echo $content?></textarea>
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