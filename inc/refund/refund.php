<?php
include('../function.inc.php');
include('../constant.inc.php');

echo "<pre>";
$grandToken=grandToken();

$data=[
    'paymentID'=>'TR0011UI1665039739670',
];
$refundStatus=refundStatus($grandToken['id_token'],'9J64SMWI68',$data);
print_r($refundStatus);
die;
$data=[
        'paymentID'=>'TR0011UI1665039739670',
        'sku'=>'ssdn',
        'reason'=>'Duplicate',
        'amount'=>1
    ];
$refundPayment=refundPayment($grandToken['id_token'],'9J64SMWI68',$data);
print_r($refundPayment);
die;
?>