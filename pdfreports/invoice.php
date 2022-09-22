<?php
session_start();
include("../inc/connection.inc.php");
include("../inc/constant.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../inc/vendor/autoload.php');
$html='
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <title><?php echo NAME." || ".TAGLINE?></title>
      <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">
      <link rel="stylesheet" href="http://localhost/admission/assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="http://localhost/admission/assets/css/style.css">
   </head>
   <body>
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
                                    <img src="http://localhost/admission/assets/img/logo.svg" alt="logo">
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
                           <div class="row" style="">
                              <div class="col-md-6">
                              </div>
                              <div class="col-md-6">
                              <div class="invoice-info">
                                 <strong class="customer-text">Invoice From</strong>
                                 <p class="invoice-details invoice-details-two">
                                    John Doe <br>
                                    806 Twin Willow Lane, Old Forge,<br>
                                    Newyork, USA <br>
                                 </p>
                              </div>
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

<script src="http://localhost/admission/assets/js/jquery-3.6.0.min.js"></script>
<script src="http://localhost/admission/assets/js/bootstrap.bundle.min.js"></script>
<script src="http://localhost/admission/assets/plugins/feather/feather.min.js"></script>
<script src="http://localhost/admission/assets/js/script.js"></script>
</body>
</html>';
// echo $html;
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 17,
	'margin_bottom' => 20,
]);
$mpdf->SetTitle('Admit Card');
$mpdf->SetFooter('|| Developed By The Web Divers');
$mpdf->WriteHTML($html);
$file="Admit_".time().'.pdf';
$mpdf->output($file,'I');