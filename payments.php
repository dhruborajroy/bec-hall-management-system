<?php include("header.php"); 
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                     <div class="col-xl-9 col-md-8">
                     <div class="settings-widget profile-details">
                        <div class="settings-inner-blk p-0">
                           <div class="profile-heading">
                              <h3>Invoices</h3>
                              <p>You can find all of your order Invoices.</p>
                           </div>
                           <div class="comman-space pb-0">
                              <div class="settings-invoice-blk table-responsive">
                                 <table class="table table-borderless mb-0">
                                    <thead>
                                       <tr>
                                          <th>order id</th>
                                          <th>date</th>
                                          <th>amount</th>
                                          <th>status</th>
                                          <th>&nbsp;</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td><a href="view-invoice.html" class="invoice-no">#1001</a></td>
                                          <td>15-01-2020, 10:45pm</td>
                                          <td>$50.00</td>
                                          <td><span class="badge status-due">Due</span></td>
                                          <td><a href="javascript:;" class="btn-style"><i class="feather-download"></i></a></td>
                                       </tr>
                                       <tr>
                                          <td><a href="view-invoice.html" class="invoice-no">#1002</a></td>
                                          <td>15-02-2020, 10:45pm</td>
                                          <td>$50.00</td>
                                          <td><span class="badge status-completed">Completed</span></td>
                                          <td><a href="javascript:;" class="btn-style"><i class="feather-download"></i></a></td>
                                       </tr>
                                    </tbody>
                                 </table>
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
