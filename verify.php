<?php
include("header.php");
$display="";
$class="";
$id="";
$msg="";
$link="";
if(isset($_GET['email']) && $_GET['email']!='' && isset($_GET['code']) && $_GET['code']!=''){
	$email=get_safe_value($_GET['email']);
	$code=get_safe_value($_GET['code']);
   $sql="select id,status from applicants where email='$email' and md5(code)='$code'";
   $res=mysqli_query($con,$sql);
   if(mysqli_num_rows($res)>0){
         $row=mysqli_fetch_assoc($res);
         if ($row['status']==1) {
            $class='class="alert alert-danger"';
            $msg="Email Already verified";
            $_SESSION['TOASTR_MSG']=array(
               'type'=>'warning',
               'body'=>'Email Already verified.',
               'title'=>'Error',
            );
         }else{
            if(mysqli_num_rows($res)>0){
               $sql="update applicants set status='1' where email='$email'";
               mysqli_query($con,$sql);
               $class='class="alert alert-success"';
               $msg='Email has been verified. Please Login.';
               $link='<a class="nav-item nav-link header-sign" href="login">Login</a>';
               $_SESSION['TOASTR_MSG']=array(
                  'type'=>'success',
                  'body'=>'Email is not registered or the verification code is not correct. Plese register & try again.',
                  'title'=>'Success',
               );
            }
         }
   }else{
      $class='class="alert alert-danger"';
      $_SESSION['TOASTR_MSG']=array(
         'type'=>'warning',
         'body'=>'Email is not registered or the verification code is not correct. Plese register & try again.',
         'title'=>'Error',
      );
      $msg="Email is not registered or the verification code is not correct. Plese register & try again.";
   }
}else{
   $_SESSION['TOASTR_MSG']=array(
     'type'=>'warning',
     'body'=>'You don\'t have permission to access this page.',
     'title'=>'Error',
   );
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
                                    <br>
                                    <?php echo $link?>
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
