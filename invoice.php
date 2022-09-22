<?php 
include("header.php");
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
if(isset($_GET['invoice']) && isset($_GET['invoice'])!=""){
   $invoice=get_safe_value($_GET['invoice']);
}else{
   redirect("dashboard");
}
$user_id=$_SESSION['APPLICANT_ID'];
$sql="select * from `applicants` where id='".$_SESSION['APPLICANT_ID']."'";
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
?>
                     <div class="page-content">
                        <div class="container">
                           <div class="row justify-content-center">
                              <div class="col-xl-9 col-md-8">
                                 <div class="settings-widget profile-details">
                                    <div class="settings-menu invoice-list-blk p-0 ">
                                       <div class="card pro-post border-0 mb-0">
                                          <div class="card-body">
                                             <div class="invoice-item">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <div class="invoice-logo">
                                                         <img src="assets/img/logo.svg" alt="logo">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <p class="invoice-details">
                                                         <strong>Order:</strong> #<?php echo $invoice?> <br>
                                                         <strong>Issued:</strong> 20/10/2021
                                                      </p>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="invoice-item">
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <div class="invoice-info">
                                                         <strong class="customer-text">Invoice From</strong>
                                                         <p class="invoice-details invoice-details-two">
                                                            John Doe <br>
                                                            806 Twin Willow Lane, Old Forge,<br>
                                                            Newyork, USA <br>
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <div class="invoice-info invoice-info2">
                                                         <strong class="customer-text">Invoice To</strong>
                                                         <p class="invoice-details">
                                                            Walter Roberson <br>
                                                            299 Star Trek Drive, Panama City, <br>
                                                            Florida, 32405, USA <br>
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="invoice-item invoice-table-wrap">
                                                <div class="row">
                                                   <div class="col-md-12">
                                                      <div class="table-responsive">
                                                         <table class="invoice-table table table-bordered">
                                                            <thead>
                                                               <tr>
                                                                  <th>Project</th>
                                                                  <th>Description</th>
                                                                  <th class="text-center">Quantity</th>
                                                                  <th class="text-end">Total</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               <tr>
                                                                  <td>Research</td>
                                                                  <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit</td>
                                                                  <td class="text-center">1</td>
                                                                  <td class="text-end">$100</td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 col-xl-4 ms-auto">
                                                      <div class="table-responsive">
                                                         <table class="invoice-table-two table table-borderless">
                                                            <tbody>
                                                               <tr>
                                                                  <th>Subtotal:</th>
                                                                  <td><span>$350</span></td>
                                                               </tr>
                                                               <tr>
                                                                  <th>Discount:</th>
                                                                  <td><span>-10%</span></td>
                                                               </tr>
                                                               <tr>
                                                                  <th>Total Amount:</th>
                                                                  <td><span>$315</span></td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  <!-- page content ended -->
               </div>
            </div>
         </div>
<?php include("footer.php")?>
