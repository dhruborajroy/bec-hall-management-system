<?php 
include('../inc/connection.inc.php');
session_start();
?>
$(document).ready(function() {
  <!-- $('#editor').summernote(); -->

  $('#summernote').summernote({
        placeholder: 'Hello Bootstrap 4',
        tabsize: 2,
        height: 100
      });
});
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Exp Name', 'Amount'],
        <?php 
        $sql="SELECT SUM(amount) as amount, expense_category.name from expense, expense_category WHERE expense.expense_category_id=expense_category.id AND expense.month='".date('m')."' group by expense_category.id";
        $res=mysqli_query($con,$sql);
        if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_assoc($res)){
                echo "['".$row['name']."', ".$row['amount']."],";
            }
        }
        ?>
        ]);

    var options = {
        title: 'Expense ',
        <!-- is3D: true, -->

    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
(function ($) {
	/*-------------------------------------
		  Bar Chart 
	  -------------------------------------*/
    
    if ($("#expense-bar-chart").length) {

    var barChartData = {
        labels: [
            <?php
            $last_date=cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            for ($i=1; $i <= $last_date; $i++) {
                echo $i.',';
            }
        ?>
        ],
        datasets: [{
        backgroundColor: ["#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01","#40dfcd", "#417dfc", "#ffaa01",],
        data: [
            <?php
            for ($i=1; $i <= $last_date; $i++) {
                $a="";
                if($i<10){
                    $a="0";
                }
                $sql="SELECT sum(amount) as amount FROM `expense` WHERE month='".date('m')."' AND date_id='$a$i' and year='".date('Y')."' order by date_id desc";
                $res=mysqli_query($con,$sql);
                while($row=mysqli_fetch_assoc($res)){
                    if($row['amount']>=0){
                        echo $row['amount'].',';
                    }else{
                        echo '0,';                                        
                    }
                }
            }
            ?>
        ],
        label: "Expenses (Daily)"
        }, ]
    };
    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 2000
        },
        scales: {

        xAxes: [{
            display: false,
            maxBarThickness: 100,
            ticks: {
                display: false,
                padding: 0,
                fontColor: "#646464",
                fontSize: 14,
            },
            gridLines: {
                display: true,
                color: '#e1e1e1',
            }
        }],
        yAxes: [{
            display: true,
            ticks: {
            display: true,
            autoSkip: false,
            fontColor: "#646464",
            fontSize: 14,
            stepSize: 5000,
            padding: 20,
            beginAtZero: true,
            callback: function (value) {
                var ranges = [{
                    divider: 1e6,
                    suffix: 'M'
                },
                {
                    divider: 1e3,
                    suffix: 'k'
                }
                ];

                function formatNumber(n) {
                for (var i = 0; i < ranges.length; i++) {
                    if (n >= ranges[i].divider) {
                    return (n / ranges[i].divider).toString() + ranges[i].suffix;
                    }
                }
                return n;
                }
                return formatNumber(value);
            }
            },
            gridLines: {
            display: true,
            drawBorder: true,
            color: '#e1e1e1',
            zeroLineColor: '#e1e1e1'

            }
        }]
        },
        legend: {
        display: false
        },
        tooltips: {
        enabled: true
        },
        elements: {}
    };
    var expenseCanvas = $("#expense-bar-chart").get(0).getContext("2d");
    var expenseChart = new Chart(expenseCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });
    }

})(jQuery);


<?php 
    if(isset($_SESSION['PERMISSION_ERROR'])){
        echo 'toastr.error("You don\'t have permission to access that location")';
    }
    unset($_SESSION['PERMISSION_ERROR']);
    if(isset($_SESSION['UPDATE'])){
        echo 'toastr.success("Data Updated successfully")';
    }
    unset($_SESSION['UPDATE']);
    if(isset($_SESSION['INSERT'])){
        echo 'toastr.success("Data inserted successfully")';
    }
    unset($_SESSION['INSERT']);
?>

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

$(document).ready(function () {
  // required part
  $("#validate").validate({
    rules: {
      // Book validation
      title: {
        required: true,
      },
      sub_title: {
        number: true,
        required: true,
      },
      isbn_ten: {
        required: true,
        number: true,
      },
      isbn_thirteen: {
        number: true,
        required: true,
      },
      department: {
        required: true,
      },
      category_id: {
        required: true,
      },
      publisher: {
        required: true,
      },
      authors: {
        required: true,
      },
      tags: {
        required: true,
      },
      edition: {
        required: true,
      },
      copies_owned: {
        required: true,
        number: true,
      },
      publish_year: {
        required: true,
        number: true,
      },
      pages: {
        required: true,
        number: true,
      },
      language: {
        required: true,
      },
      note: {
        required: true,
      },
      description: {
        required: true,
      },
      //Manage User validation

      name: {
        required: true,
      },
      roll: {
        required: true,
        number: true,
      },
      fName: {
        required: true,
      },
      fOccupation: {
        required: true,
      },
      mName: {
        required: true,
      },
      mOccupation: {
        required: true,
      },
      phoneNumber: {
        required: true,
        nunmber: true,
        minlength: 11,
      },
      email: {
        required: true,
        email: true,
      },
      presentAddress: {
        required: true,
      },
      permanentAddress: {
        required: true,
      },
      dob: {
        required: true,
      },
      birthId: {
        required: true,
        minlength: 13,
        number: true,
      },
      gender: {
        required: true,
      },
      bloodGroup: {
        required: true,
      },
      religion: {
        required: true,
      },
      dept_id: {
        required: true,
        number: true,
      },
      ffQuata: {
        required: true,
      },
      examRoll: {
        required: true,
        number: true,
      },
      merit: {
        required: true,
      },
      legalGuardianName: {
        required: true,
      },
      legalGuardianRelation: {
        required: true,
      },
      // Notice
      details: {
        required: true,
      },

      //   Department
      name: {
        required: true,
      },
      short_form: {
        required: true,
      },
      //   Batch
      numaric_value: {
        required: true,
      },
      //issue
      book_id: {
        required: true,
      },
      user_id: {
        required: true,
      },
      issue_date: {
        required: true,
        number: true,
      },
      expire_date: {
        required: true,
        number: true,
      },
      return_date: {
        required: true,
        number: true,
      },
    },
    messages: {},
  });

  if ($.fn.vectorMap !== undefined) {
    ClassicEditor.create(document.querySelector("#description")).catch(
      (error) => {
        console.error(error);
      }
    );
    ClassicEditor.create(document.querySelector("#note")).catch((error) => {
      console.error(error);
    });

    ClassicEditor.create(document.querySelector("#details")).catch((error) => {
      console.error(error);
    });
  }