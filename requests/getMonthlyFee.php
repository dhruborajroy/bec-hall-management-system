<?php 
if(isset($_POST['month_id']) && $_POST['month_id']>0 && $_POST['month_id']!=0){
    $month_id=$_POST['month_id'];
    if ($month_id==1) {
        echo "6600";
    }else if ($month_id==2) {
        echo "5500";
    }else if ($month_id==3) {
        echo "5200";
    }else if ($month_id==4) {
        echo "3000";
    }else{
        echo "0";
    }
}
if(isset($_POST['fee_id']) && $_POST['fee_id']>0 && $_POST['fee_id']!=0){
    $fee_id=$_POST['fee_id'];
    if ($fee_id==1) {
        echo "300";
    }else if ($fee_id==2) {
        echo "100";
    }else{
        echo "0";
    }
}