<?php 
include('../inc/connection.inc.php');
session_start();
?>
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

<?php
$last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
$dailyCollection = [];
for ($i=1; $i <= $last_date; $i++) {
    $a = ($i < 10) ? "0" : "";
    // Day window (epoch)
    $dayStart = strtotime(date('Y-m-').$a.$i.' 00:00:00');
    $dayEnd   = strtotime(date('Y-m-').$a.$i.' 23:59:59');

    // Sum paid collections from payments (authoritative)
    $sql = "SELECT COALESCE(SUM(COALESCE(total_amount,totalamount)),0) AS amt
            FROM payments
            WHERE COALESCE(paid_status,paidstatus,1)=1
              AND COALESCE(created_at,createdat,0) BETWEEN {$dayStart} AND {$dayEnd}";
    $res = mysqli_query($con, $sql);
    $row = $res ? mysqli_fetch_assoc($res) : ['amt'=>0];
    $dailyCollection[] = (float)$row['amt'];
}
?>


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
        datasets: [
  {
    backgroundColor: [/* your color array */],
    data: [
      <?php
        for ($i=1; $i <= $last_date; $i++) {
            $a = ($i<10) ? "0" : "";
            $sql="SELECT SUM(amount) AS amount FROM expense WHERE month='".date('m')."' AND date_id='$a$i' AND year='".date('Y')."'";
            $res=mysqli_query($con,$sql);
            $row=mysqli_fetch_assoc($res);
            echo ($row && $row['amount']>=0) ? (float)$row['amount'].',' : '0,';
        }
      ?>
    ],
    label: "Expenses (Daily)"
  },
  {
    type: 'line', // overlay line for contrast; change to 'bar' for grouped bars
    label: "Collections (Daily)",
    borderColor: "#2e7d32",
    backgroundColor: "rgba(46,125,50,0.12)",
    borderWidth: 2,
    pointRadius: 3,
    fill: true,
    data: [<?php echo implode(',', array_map('floatval', $dailyCollection)); ?>]
  }
]

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
