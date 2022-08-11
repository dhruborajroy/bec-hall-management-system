<!-- Footer Area Start Here -->
<footer class="footer-wrap-layout1">
    <div class="copyright">© Copyrights <a href="#">Barishal Engineering College Hall </a> 2018-<?php echo date('Y')?>. All
        rights reserved. Developed by <a href="https://dhruborajroy.github.io/myPortfollioWebsite">Dhrubo</a></div>
</footer>
<!-- Footer Area End Here -->
</div>
</div>
<!-- Page Area End Here -->
</div>
<!-- jquery-->
<script src="../js/jquery-3.3.1.min.js"></script>
<!-- Plugins js -->
<script src="../js/plugins.js"></script>
<!-- Popper js -->
<script src="../js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="../js/bootstrap.min.js"></script>
<!-- Counterup Js -->
<script src="../js/jquery.counterup.min.js"></script>
<!-- Moment Js -->
<script src="../js/moment.min.js"></script>
<!-- Waypoints Js -->
<script src="../js/jquery.waypoints.min.js"></script>
<!-- Scroll Up Js -->
<script src="../js/jquery.scrollUp.min.js"></script>
<!-- Full Calender Js -->
<script src="../js/fullcalendar.min.js"></script>
<!-- Select 2 Js -->
<script src="../js/select2.min.js"></script>
<!-- Date Picker Js -->
<script src="../js/datepicker.min.js"></script>
<!-- Chart Js -->
<script src="../js/Chart.min.js"></script>
<!-- Scroll Up Js -->
<script src="../js/jquery.scrollUp.min.js"></script>
<!-- Data Table Js -->
<script src="../js/jquery.dataTables.min.js"></script>
<!-- Vailidate Js -->
<script src="../../assets/js/jquery.validate.js"></script>
<!-- Custom Js -->
<script src="../js/toastr.min.js"></script>
<!-- sweet alert JS -->
<script src="../assets/js/sweetalert.min.js"></script>
<!-- Custom Js -->
<script src="../js/main.js"></script>

<script>
toastr.options = {
    "closeButton": true,
    "debug": true,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function toastrSuccess(data) {
    toastr.success(data);
}

function toastrInfo(data) {
    toastr.info(data);
}

function toastrWarning(data) {
    toastr.warning(data);
}

function toastrError(data) {
    toastr.error(data);
}
</script>
<!-- Dynamic Custom Js -->
<script src="js/custom.php"></script>

<script>
function vailidatePayment(val_id) {
    var val_id = val_id;
    // alert(val_id);
    jQuery.ajax({
        url: 'vailidatePayment.php',
        type: 'post',
        data: 'val_id=' + val_id,
        success: function(result) {
            if (result == 'VALID' || result == 'VALIDATED') {
                swal("Success!", "Your payment is valid!", "success");
            } else if (result == 'INVALID_TRANSACTION') {
                swal("Failure!", "Your payment is Invalid!", "warning");
            } else {
                alert(result);
            }
        }
    });
}
$().ready(function() {
    // validate signup form on keyup and submit
    $("#studentForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            lastname: "required",
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            file_ip_1: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            name: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy",
            topic: "Please select at least 2 topics"
        }
    });
});
</script>
</body>

</html>