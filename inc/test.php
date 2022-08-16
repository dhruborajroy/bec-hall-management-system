<?php
include("./connection.inc.php");

$sqll="SELECT * from users";
$ress=mysqli_query($con,$sqll);
if(mysqli_num_rows($ress)>0){
$i=1;
while($roww=mysqli_fetch_assoc($ress)){
?>
<tr role="row" class="odd">
    <td>
        <input type="checkbox" value="<?php //echo $i?>" 
        <?php 
        $resss=mysqli_query($con,"select user_id from purchaser where purchaser.expense_id='3'"); 
        if(mysqli_num_rows($resss)){
            $rows=mysqli_fetch_assoc($resss);
                // if($rows['user_id']==$roww['roll']){
                    echo 'checked ';
                    echo " Roll: ".$roww['roll']."<br>";
                    echo " User ".$rows['user_id']."<br>";
                    echo $disabled="";
                // }
            
        }?> id="checkbox_<?php //echo $i?>"  onchange="add_purchaser(this.value)">

        <input <?php //echo $disabled?> type="hidden" id="roll_<?php //echo $i?>" name="purchaser_roll[]" value="<?php echo  $roww['roll']?>"> 
        
    </td>
</tr>
<?php 
$i++;
} } else { ?>
<tr>
    <td colspan="5">No data found</td>
</tr>
<?php } ?>