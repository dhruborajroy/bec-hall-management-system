<?php include("header.php"); 
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                  <div class="col-xl-9 col-lg-8 col-md-12">
                     <div class="row">
                        <div class="col-md-4 d-flex">
                           <div class="card instructor-card w-100">
                              <div class="card-body">
                                 <div class="instructor-inner">
                                    <h6>Result</h6>
                                    <h4 class="instructor-text-success">27<sup>th</sup></h4>
                                    <!-- <p>Earning this month</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 d-flex">
                           <div class="card instructor-card w-100">
                              <div class="card-body">
                                 <div class="instructor-inner">
                                    <h6>Marks</h6>
                                    <h4 class="instructor-text-info">67</h4>
                                    <!-- <p>New this month</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="settings-widget">
                              <div class="settings-inner-blk p-0">
                                 <div class="sell-course-head comman-space">
                                    <h3>Obtained Marks</h3>
                                 </div>
                                 <div class="comman-space pb-0">
                                    <div class="settings-tickets-blk course-instruct-blk table-responsive">
                                       <table class="table table-nowrap mb-0">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>Subjets</th>
                                                <th>Marks</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td>1</td>
                                                <td>Bangla</td>
                                                <td>34</td>
                                             </tr>
                                             <tr>
                                                <td>2</td>
                                                <td>English</td>
                                                <td>34</td>
                                             </tr>
                                             <tr>
                                                <td>3</td>
                                                <td>Math</td>
                                                <td>34</td>
                                             </tr>
                                          </tbody>
                                          <tfoot>
                                             <tr>
                                                <th colspan="2" align="right">Total Marks</th>
                                                <th>67</th>
                                             </tr>
                                          </tfoot>
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
<?php include("footer.php")?>
