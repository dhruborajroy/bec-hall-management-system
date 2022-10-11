
         <footer class="footer d-print-none">
            <div class="footer-top">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-4 col-md-6">
                        <div class="footer-widget footer-about">
                           <div class="footer-logo">
                              <img src="assets/img/logo.svg" alt="logo">
                           </div>
                           <div class="footer-about-content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consequat mauris</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-6">
                        <div class="footer-widget footer-menu">
                           </ul>
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-6">
                        <div class="footer-widget footer-menu">
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6">
                        <div class="footer-widget footer-contact">
                           <h2 class="footer-title">News letter</h2>
                           <div class="news-letter">
                              <form>
                                 <input type="text" class="form-control" placeholder="Enter your email address" name="email">
                              </form>
                           </div>
                           <div class="footer-contact-info">
                              <div class="footer-address">
                                 <img src="assets/img/icon/icon-20.svg" alt="" class="img-fluid">
                                 <p> 3556 Beech Street, San Francisco,<br> California, CA 94108 </p>
                              </div>
                              <p>
                                 <img src="assets/img/icon/icon-19.svg" alt="" class="img-fluid">
                                 <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="c4a0b6a1a5a9b7a8a9b784a1bca5a9b4a8a1eaa7aba9">[email&#160;protected]</a>
                              </p>
                              <p class="mb-0">
                                 <img src="assets/img/icon/icon-21.svg" alt="" class="img-fluid">
                                 +19 123-456-7890
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer-bottom">
               <div class="container">
                  <div class="copyright">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="privacy-policy">
                              <ul>
                                 <li><a href="term-condition.html">Terms</a></li>
                                 <li><a href="privacy-policy.html">Privacy</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="copyright-text">
                              <p class="mb-0">&copy; 2022 DreamsLMS. All rights reserved.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <script src="assets/js/jquery-3.6.0.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script src="assets/plugins/feather/feather.min.js"></script>
      <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
      <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
      <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
      <script src="assets/plugins/apexchart/chart-data.js"></script>
      <script src="assets/js/toastr.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="assets/js/script.js"></script>
      <script>
         //info
         //warning
         //success
         //error
         function toastrMsg(msgType,title,body){
            toastr.options = {
               "closeButton": true,
               "debug": false,
               "newestOnTop": true,
               "progressBar": true,
               "positionClass": "toast-top-right",
               "preventDuplicates": false,
               "onclick": null,
               "showDuration": "30",
               "hideDuration": "1000",
               "timeOut": "30000",
               "extendedTimeOut": "1000",
               "showEasing": "swing",
               "hideEasing": "linear",
               "showMethod": "fadeIn",
               "hideMethod": "fadeOut"
            }
            toastr[msgType](body, title);
         }

         var x=1;
         function validateImage(event){
            document.getElementById('result').innerHTML='';
            if(x==2){
               document.getElementById('result').innerHTML="";
               x=1;
            }
            var image=document.getElementById('image');
            var filename=image.value;
            if(filename!=''){
               var extdot=filename.lastIndexOf(".")+1;
               var ext=filename.substr(extdot,filename.lenght).toLowerCase();
               if(ext=="jpg" || ext=="png" || ext=="jpeg"){
                  x=2;
                  var src=URL.createObjectURL(event.target.files[0]);
                  // image.after(output);
                  document.getElementById('result').innerHTML='<img class="image-preview"  src="'+src+'" height="300px" weight="300px"/>';
               }else{
                  document.getElementById('result').innerHTML='Please select only jpg and png file';
               }
            }
         }
      </script>
   </body>
</html>
<?php
if(isset($_SESSION['TOASTR_MSG'])){?>
   <script>
      toastrMsg('<?php echo $_SESSION['TOASTR_MSG']['type']?>',"<?php echo $_SESSION['TOASTR_MSG']['body']?>","<?php echo $_SESSION['TOASTR_MSG']['title']?>");
   </script>
<?php 
unset($_SESSION['TOASTR_MSG']);
}
?>