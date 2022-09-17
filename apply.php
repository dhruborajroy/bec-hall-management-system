<?php include("header.php");?>

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
                              </div>
                              <div class="checkout-form">
                                 <form action="#">
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">First Name</label>
                                             <input type="text" name="first_name" id="first_name"  class="form-control" placeholder="Enter your first Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Last Name</label>
                                             <input type="text" name="last_name" id="last_name" class="form-control"  placeholder="Enter your last Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Father's Name</label>
                                             <input type="text" name="f_name" id="f_name" class="form-control" placeholder="Enter your father's Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Mother's Name</label>
                                             <input type="text" name="m_name" id="m_name" class="form-control" placeholder="Enter your mother's Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Phone Number</label>
                                             <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Email</label>
                                             <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="form-group">
                                             <label class="form-control-label">Present Address</label>
                                             <input type="text" name="present_address" id="present_address" class="form-control" placeholder="Present address">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="form-group">
                                             <label class="form-control-label">Permanent Address</label>
                                             <input type="text" name="permanent_address" id="permanent_address" class="form-control" placeholder="Permanent address">
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Gender</label>
                                             <select class="form-select select" name="gender" id="gender">
                                                <option>Select Gender</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Blood Group</label>
                                             <select class="form-select select" name="bloodgroup" id="bloodgroup">
                                                <option>Select Bloodgroup</option>
                                                <option>A+</option>
                                                <option>A-</option>
                                                <option>B+</option>
                                                <option>B-</option>
                                                <option>AB+</option>
                                                <option>AB-</option>
                                                <option>O+</option>
                                                <option>O-</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Religion</label>
                                             <select class="form-select select" name="religion" id="religion">
                                                <option>Select Religion</option>
                                                <option>Islam</option>
                                                <option>Hinduism</option>
                                                <option>Buddha</option>
                                                <option>Christian</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-8">
                                          <div class="form-group">
                                             <label class="form-control-label">Date of Birth</label>
                                             <input type="date" name="dob" id="dob" class="form-control" placeholder="Date of birth">
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Quota</label>
                                             <select class="form-select select" name="quota" id="quota">
                                                <option>Select quota</option>
                                                <option>Freedom Fighter Quota</option>
                                                <option>Tribal Quota</option>
                                                <option>Disabled Quota</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Password</label>
                                             <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Confirm Password</label>
                                             <input type="password" name="password" id="password" class="form-control" placeholder="Confirm password">
                                          </div>
                                       </div>
                                       <div class="payment-btn" style="text-align:right ;">
                                          <button class="btn btn-primary" type="submit">Submit</button>
                                       </div>
                                       <!-- <div class="col-md-12 col-lg-10">
                                          <div class="form-group ship-check">
                                             <input class="form-check-input" type="checkbox" name="remember"> Shipping address is the same as my billing address
                                          </div>
                                          <div class="form-group ship-check mb-0">
                                             <input class="form-check-input" type="checkbox" name="remember"> Save this information for next time
                                          </div>
                                       </div> -->
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                  </div>

               <div class="col-lg-1">
                  </div>
            </div>
         </section>
<?php include("footer.php");?>
