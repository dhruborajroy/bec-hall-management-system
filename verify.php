<?php
include("header.php");
$display="";
$class="";
$id="";
$msg="";
if(isset($_GET['email']) && $_GET['email']!='' && isset($_GET['code']) && $_GET['code']!=''){
	$email=get_safe_value($_GET['email']);
	$code=get_safe_value($_GET['code']);
   $sql="select id from applicants where email='$email'";
   if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $class='class="alert alert-danger"';
         $msg="Email Already verified";
   }else{
      $sql="select id from applicants where email='$email' and md5(code)='$code' ";
      if(mysqli_num_rows(mysqli_query($con,$sql))>0){
         $sql="update applicants set status='1'";
         mysqli_query($con,$sql);
         $class='class="alert alert-success"';
         $msg="An Email has been sent to your $email account. Please Verify your email";
         $_SESSION['INSERT']=1;
      }else{
         $class='class="alert alert-danger"';
         $msg="Email is not registered. Plese register & try again.";
      }
   }
   echo $sql;
}else{
   $_SESSION['PERMISSION_ERROR']="You don't have permission to access this page.";
   redirect("index");
}?>
<div class="breadcrumb-bar">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-12">
            <div class="breadcrumb-list">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index">Home</a></li>
                     <li class="breadcrumb-item" aria-current="page">Apply</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
</div>
<section class="course-content checkout-widget">
            <div class="container">
               <div class="row">
                  <div class="col-lg-1">
                  </div>
                     <div class="col-lg-10">
                        <div class="student-widget">
                           <div class="student-widget-group add-course-info">
                              <div class="cart-head">
                                    <h4>Applicant Form</h4>
                                 <center>
                                    <span <?php echo $class?>><?php echo $msg?></span>
                                 </center>
                              </div>
                           </div>
                        </div>
                  </div>
               <div class="col-lg-1">
               </div>
            </div>
         </section>
<?php include("footer.php");?>
