<?php 
include('../inc/connection.inc.php')
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
        data: [
            <?php
            for ($i=1; $i <= $last_date; $i++) {
                $sql="SELECT sum(amount) as amount FROM `expense` WHERE month='".date('m')."' AND date_id='$i' and year='".date('Y')."' order by date_id desc";
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
            stepSize: 250,
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

ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
    console.error( error );
} );