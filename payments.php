<?php include("inc/constant.inc.php")?>
<?php include("inc/connection.inc.php")?>
<?php include("header.php")?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>

                  <!-- page content started -->
                  <div class="col-xl-9 col-lg-8 col-md-12">
                     <div class="tak-instruct-group">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="settings-widget">
                                 <div class="settings-inner-blk p-0">
                                    <div class="sell-course-head comman-space">
                                       <h3>Payout Method</h3>
                                       <p>Order Dashboard is a quick overview of all current orders.</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="settings-widget">
                                 <div class="settings-inner-blk p-0">
                                    <div class="comman-space pb-0">
                                       <div class="sell-course-head withdraw-history-head border-bottom-0">
                                          <h3>Withdraw History</h3>
                                       </div>
                                       <div class="instruct-search-blk mb-0">
                                          <div class="show-filter all-select-blk">
                                             <form action="#">
                                                <div class="row gx-2 align-items-center">
                                                   <div class="col-md-6 col-lg-3 col-item">
                                                      <div class="form-group select-form mb-0">
                                                         <select class="form-select select" name="sellist1">
                                                            <option>30 days</option>
                                                            <option>20 days</option>
                                                            <option>10 days</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 col-lg-3 col-item">
                                                      <div class="form-group select-form mb-0">
                                                         <select class="form-select select" name="sellist1">
                                                            <option>Oct 2020</option>
                                                            <option>Nov 2020</option>
                                                            <option>Jan 2021</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 col-lg-3 col-item">
                                                      <div class="form-group select-form mb-0">
                                                         <select class="form-select select" name="sellist1">
                                                            <option>Transaction Type</option>
                                                            <option>Cash</option>
                                                            <option>Card</option>
                                                            <option>Online</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 col-lg-3 col-item">
                                                      <div class="download-widra">
                                                         <a href="javascript:;"><i class="feather-download"></i></a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="comman-space pb-0">
                                       <div class="settings-referral-blk course-instruct-blk  table-responsive">
                                          <table class="table table-nowrap mb-0">
                                             <thead>
                                                <tr>
                                                   <th>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </th>
                                                   <th>ID</th>
                                                   <th>DATE</th>
                                                   <th>STATUS</th>
                                                   <th>AMOUNT</th>
                                                   <th>METHOD	</th>
                                                   <th>&nbsp;</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$1800</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1051</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$1200</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#2061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-medium">Pending</span></td>
                                                   <td>$1100</td>
                                                   <td>Visa</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1021</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-high">Cancel</span></td>
                                                   <td>$1200</td>
                                                   <td>Visa	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1051</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$1500</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$2200</td>
                                                   <td>Visa	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#2061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$3200</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1161</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$1400</td>
                                                   <td>Visa	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#3061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-low">Paid</span></td>
                                                   <td>$1300</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
                                                </tr>
                                                <tr>
                                                   <td>
                                                      <div class="form-check instruct-check-list">
                                                         <input class="form-check-input" type="checkbox" name="option1">
                                                      </div>
                                                   </td>
                                                   <td><a href="view-invoice.html">#1061</a></td>
                                                   <td>10-05-20</td>
                                                   <td><span class="badge info-high">Cancel</span></td>
                                                   <td>$1200</td>
                                                   <td>Mastercard	</td>
                                                   <td><a href="javascript:;"><i class="feather-more-vertical"></i></a></td>
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
                  <!-- page content ended -->
               </div>
            </div>
         </div>
<?php include("footer.php")?>
