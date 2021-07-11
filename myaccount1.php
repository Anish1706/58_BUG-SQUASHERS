<?php
include_once('include/header.php');
include_once('include/nav.php');
include_once('phplib/view1.php');
include_once('phplib/controller1.php');
if(isset($_SESSION['UserEmail']) && isset($_SESSION['UserFullName']))
{
    if(!isset($_GET['name']))
    {
        echo "<script>window.open('myaccount1.php?name=TXkgQWNjb3VudA==','_self');</script>";
    }
   $gloabvar=getuserdetailsbyemail();
}
else
{
    echo "<script>window.open('login1.php?name=VXNlciBMb2dpbg==','_self');</script>";
}
?>
<div style="margin-top: 50px;">&nbsp;</div>




<div class="col-sm-10 col-sm-offset-1">
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">My Account</a></li>
    <li><a data-toggle="tab" href="#menu1">Edit Account</a></li>
    <li><a data-toggle="tab" href="#menu2">Change Password</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     <table class="table" style="border:1px solid #5bc0de;">
     	<tr>
     		<td>Name : </td>
     		<td><?php echo $gloabvar['shopk_name']; ?></td>
     	</tr>
     	<tr>
     		<td>Email : </td>
     		<td><?php echo $gloabvar['shopk_mail']; ?></td>
     	</tr>
     	<tr>
     		<td>Phone : </td>
     		<td><?php echo $gloabvar['shopk_phone']; ?></td>
     	</tr>
     	<tr>
     		<td>Billing Address : </td>
     		<td><?php echo $gloabvar['shopk_address']; ?></td>
     	</tr>
     	
     </table>
    </div>
    

    <div id="menu1" class="tab-pane fade">
      <form action="myaccount.php" method="post">
      <table class="table" style="border:1px solid #5bc0de;">
     	<tr>
     		<td>Name : </td>
     		<td> <input type="text" name="txtCustomerName" required value="<?php echo $gloabvar['shopk_name']; ?>" style="width: 100%;"></td>
     	</tr>
     	<tr>
     		<td>Email : </td>
     		<td> <input type="text" readonly name="txtCustomerEmail" value="<?php echo $gloabvar['shopk_mail']; ?>" style="width: 100%;"></td>
     	</tr>
     	<tr>
     		<td>Phone : </td>
     		<td> <input type="text" name="txtCustomerPhone" required value="<?php echo $gloabvar['shopk_phone']; ?>" style="width: 100%;"></td>
     	</tr>
     	<tr>
     		<td> Address : </td>
     		<td> <input type="text" name="txtCustomerBilling" value="<?php echo $gloabvar['shopk_address']; ?>" style="width: 100%;"></td>
			<input type="hidden" name="txtCustomerID"  value="<?php echo $gloabvar['shopk_id']; ?>">
     	</tr>
     	
     	<tr>
     		<td colspan="2" align="center"> <input type="submit" value="Update Info" class="btn btn-info"  name="btnSubmit"></td>
     	</tr>
     </table>
     </form>
    </div>
    <div id="menu2" class="tab-pane fade">
    <form action="myaccount.php?name=TXkgQWNjb3VudA==" method="post"> 
    <table class="table" style="border:1px solid #5bc0de;">
    	<tr>
    		<td class="text-right"> New Password : </td>
    		<td> <input type="password" name="txtPassword" required id="txtPassword"> </td>
    	</tr>
    	<tr>
    		<td class="text-right"> Confirm Password : </td>
    		<td> <input type="password" name="txtRepassword" required id="txtRepassword" onblur="checkpassword()"> </td>
    	</tr>
        <input type="hidden" name="txtCustomerID"  value="<?php echo $gloabvar['shopk_id']; ?>">
    	<tr align="center">
    		<td colspan="2"> <input type="submit" class="btn btn-info" name="btnChangePassword" value="submit"> </td>
    	</tr>
    </table>
    </form>
   </div>
  </div><div style="margin-bottom: 50px;">&nbsp;</div>
</div>

</div>
<?php
include_once('include/footer.php');
if(isset($_POST['btnSubmit']))
{
    global $con;
    $sql="UPDATE `shop_reg` SET `shopk_name`='".mysqli_real_escape_string($con,$_POST['txtCustomerName'])."',`shopk_phone`='".mysqli_real_escape_string($con,$_POST['txtCustomerPhone'])."',`shopk_address`='".mysqli_real_escape_string($con,$_POST['txtCustomerBilling'])."' WHERE `shopk_id`='".mysqli_real_escape_string($con,$_POST['txtCustomerID'])."'";    

    if($result=$con->query($sql))
    {
        echo "<script>alert('Profile Updated');</script>";
        echo "<script>window.open('myaccount1.php?name=TXkgQWNjb3VudA==','_self');</script>";
    }
    else
    {
        echo "<script>alert('Query Error');</script>";

    }
}
else if(isset($_POST['btnChangePassword']))
{
    global $con;
    $sql="UPDATE `shop_reg` SET `shopk_pass`='".mysqli_real_escape_string($con,md5($_POST['txtPassword']))."' WHERE `shopk_id`='".mysqli_real_escape_string($con,$_POST['txtCustomerID'])."'";
    if($result=$con->query($sql))
    {
        echo "<script>alert('Password Updated');</script>";
        echo "<script>window.open('myaccount1.php?name=TXkgQWNjb3VudA==','_self');</script>";
    }
    else
    {
        echo "<script>alert('Query Error');</script>";

    }
}
?>
<script>
    function checkpassword()
    {
        if(document.getElementById("txtPassword").value != document.getElementById("txtRepassword").value)
        {
            document.getElementById("txtPassword").style="border-color:red";
            document.getElementById("txtPassword").value="";
            document.getElementById("txtRepassword").style="border-color:red";
            document.getElementById("txtRepassword").value="";
        }
    }
</script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
 $(document).on('ready', function () {
        $('.kv-gly-star').rating({
            containerClass: 'is-star'
        });
        $('.kv-gly-heart').rating({
            containerClass: 'is-heart',
            defaultCaption: '{rating} hearts',
            starCaptions: function (rating) {
                return rating == 1 ? 'One heart' : rating + ' hearts';
            },
            filledStar: '<i class="glyphicon glyphicon-heart"></i>',
            emptyStar: '<i class="glyphicon glyphicon-heart-empty"></i>'
        });
        $('.kv-fa').rating({
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>'
        });
        $('.kv-fa-heart').rating({
            defaultCaption: '{rating} hearts',
            starCaptions: function (rating) {
                return rating == 1 ? 'One heart' : rating + ' hearts';
            },
            theme: 'krajee-fa',
            filledStar: '<i class="fa fa-heart"></i>',
            emptyStar: '<i class="fa fa-heart-o"></i>'
        });
        $('.kv-uni-star').rating({
            theme: 'krajee-uni',
            filledStar: '&#x2605;',
            emptyStar: '&#x2606;'
        });
        $('.kv-uni-rook').rating({
            theme: 'krajee-uni',
            defaultCaption: '{rating} rooks',
            starCaptions: function (rating) {
                return rating == 1 ? 'One rook' : rating + ' rooks';
            },
            filledStar: '&#9820;',
            emptyStar: '&#9814;'
        });
        $('.kv-svg').rating({
            theme: 'krajee-svg',
            filledStar: '<span class="krajee-icon krajee-icon-star"></span>',
            emptyStar: '<span class="krajee-icon krajee-icon-star"></span>'
        });
        $('.kv-svg-heart').rating({
            theme: 'krajee-svg',
            filledStar: '<span class="krajee-icon krajee-icon-heart"></span>',
            emptyStar: '<span class="krajee-icon krajee-icon-heart"></span>',
            defaultCaption: '{rating} hearts',
            starCaptions: function (rating) {
                return rating == 1 ? 'One heart' : rating + ' hearts';
            },
            containerClass: 'is-heart'
        });

        $('.rating,.kv-gly-star,.kv-gly-heart,.kv-uni-star,.kv-uni-rook,.kv-fa,.kv-fa-heart,.kv-svg,.kv-svg-heart').on(
                'change', function () {
                    console.log('Rating selected: ' + $(this).val());
                });
    });
</script>
</body>
</html>