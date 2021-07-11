<?php
include_once('db_config.php');
date_default_timezone_set('Asia/Kolkata');

//Create New Account
function RegisterNewUser($shopk_email,$shopk_name,$shopk_phone,$shopk_pass,$retypepassword,$shopk_address)
{

	//Check Email Already Exist Or Not
	global $con;
	$sql121="SELECT `shopk_email` FROM `shop_reg` WHERE `shopk_email`='".mysqli_real_escape_string($con,$shopk_email)."' ";
	$result121=$con->query($sql121);
	if ($result121->num_rows < 1) {
		if(strlen($shopk_name)>0 && strlen($shopk_phone)>0 && strlen($shopk_pass)>0 && strlen($shopk_address) && strlen($retypepassword)>0)
		{
			if($shopk_pass==$retypepassword)
			{
				global $con;
				$sql="INSERT INTO `shop_reg`(`shopk_email`, `shopk_name`, `shopk_phone`, `shopk_pass`) VALUES ('".mysqli_real_escape_string($con,$shopk_email)."','".mysqli_real_escape_string($con,$shopk_name)."','".mysqli_real_escape_string($con,$shopk_phone)."','".mysqli_real_escape_string($con,md5($shopk_pass))."')";
				if($con->query($sql) === true){
					echo "
					<div class='alert alert-success alert-dismissible' role='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					  <strong>success!</strong> you can login your account.
					</div>

					";
				}
			}
			else
			{
				echo "
					<div class='alert alert-danger alert-dismissible' role='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					  <strong>Oh snap!</strong> shopk_pass And Retype shopk_pass Should Be Same.
					</div>

					";
			}
		}
		else
		{
			echo "
					<div class='alert alert-danger alert-dismissible' role='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					  <strong>Oh snap!</strong> Change a few things up and try submitting again.
					</div>

					";
		}
	}
	else
	{
		echo "
				<div class='alert alert-danger alert-dismissible' role='alert'>
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				  <strong>Oh snap!</strong> Email Already Exist. <a href='forgot.php'>Forgot shopk_pass?</a>
				</div>

				";
	}

	
}

//function create check login
function checklogin($email,$shopk_pass,$redirect)
{
	global $con;
	$sql="SELECT `shopk_email`, `shopk_name`, `shopk_pass`  FROM `shop_reg` WHERE  `shopk_email`='".mysqli_real_escape_string($con,$email)."' ";
	$result=$con->query($sql);

	if($result->num_rows>0)
	{
		$row=$result->fetch_assoc();
		if($row['shopk_pass']==md5($shopk_pass) && $row['shopk_email']==$email)
		{
			session_start();
			$_SESSION["UserEmail"]=$email;
			$_SESSION["UserFullName"]=$row['shopk_name'];
			if(strlen($redirect)>0)
			{
				echo "<script>window.open('".$redirect."','_self');</script>";
			}
			else{
			echo "<script>window.open('myaccount.php','_self');</script>";
			}
		}
		else
		{
			echo "
				<div class='alert alert-danger alert-dismissible' role='alert'>
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				  <strong>Oh snap!</strong> Enter Valid Email Or shopk_pass.
				</div>

				";
		}
	}
	else
	{

		echo "
				<div class='alert alert-danger alert-dismissible' role='alert'>
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				  <strong>Oh snap!</strong> Enter Valid Email Or shopk_pass. Or <a href='register.php?name=".base64_encode('Create New Account')."'>Create Account?</a>
				</div>

				";
	}
}


///this function update cart item
function updatecateitem($cart_id,$qty)
{
	global $con;
	$sql="UPDATE `balas_cart` SET `qty`='".mysqli_real_escape_string($con,$qty)."' WHERE `Cart_ID`='".mysqli_real_escape_string($con,$cart_id)."' ";

	if($con->query($sql)){
		echo "<script>alert('Cart Updated')</script>";
	}
}

// this function detete cart item
function deletecart($id)
{
	global $con;
	$sql="DELETE FROM `balas_cart` WHERE `Cart_ID`='".base64_decode($id)."' ";

	if($con->query($sql))
	{
		echo "<script>alert('Item Deleted');</script>";
	}
}


//this function place order
function placeorder($txtName,$txtEmail,$txtPhone,$txtAddress,$txtLandmark,$txtPincode,$txtState,$txtTotalAmount,$txtCartId,$txtDelivaryCharge,$txtMode)
{
	global $con;

	if($txtMode=="Online")
	{
		$sql="INSERT INTO `balas_order`(`cart_id`, `order_by`, `email`, `phone`, `address`, `landmark`, `pin`, `state`, `totalamount`, `deliverycharge`, `date`, `time`, `mode`) VALUES ('".mysqli_real_escape_string($con,$txtCartId)."','".mysqli_real_escape_string($con,$txtName)."','".mysqli_real_escape_string($con,$txtEmail)."','".mysqli_real_escape_string($con,$txtPhone)."','".mysqli_real_escape_string($con,$txtAddress)."','".mysqli_real_escape_string($con,$txtLandmark)."','".mysqli_real_escape_string($con,$txtPincode)."','".mysqli_real_escape_string($con,$txtState)."','".mysqli_real_escape_string($con,$txtTotalAmount)."','".mysqli_real_escape_string($con,$txtDelivaryCharge)."','".mysqli_real_escape_string($con,date('d-m-Y'))."','".mysqli_real_escape_string($con,date('H:i'))."','".mysqli_real_escape_string($con,$txtMode)."')";

	}
	else
	{
		$sql="INSERT INTO `balas_order`(`cart_id`, `order_by`, `email`, `phone`, `address`, `landmark`, `pin`, `state`, `totalamount`, `deliverycharge`, `date`, `time`, `mode`,`payment`) VALUES ('".mysqli_real_escape_string($con,$txtCartId)."','".mysqli_real_escape_string($con,$txtName)."','".mysqli_real_escape_string($con,$txtEmail)."','".mysqli_real_escape_string($con,$txtPhone)."','".mysqli_real_escape_string($con,$txtAddress)."','".mysqli_real_escape_string($con,$txtLandmark)."','".mysqli_real_escape_string($con,$txtPincode)."','".mysqli_real_escape_string($con,$txtState)."','".mysqli_real_escape_string($con,$txtTotalAmount)."','".mysqli_real_escape_string($con,$txtDelivaryCharge)."','".mysqli_real_escape_string($con,date('Y-m-d'))."','".mysqli_real_escape_string($con,date('H:i'))."','".mysqli_real_escape_string($con,$txtMode)."','1')";
	}

	
	$result=$con->query($sql);
	$OrderId="#ORDBALAS".mysqli_insert_id($con);
	if($result>0)
	{
		if($txtMode=="Online")
		{
			//Online Code Here
			echo "<script>window.open('ccavenue.php?oderid=".base64_encode($OrderId)."','_self');</script>";
		}
		else
		{
		session_start();
		unset($_SESSION['uniqueSessionID']);

		$to = 'contact.balaskolkata@gmail.com';
		$subject = 'New Order From Website-- Order Id-'.$OrderId;
		$from = 'order@balaskolkata.com';
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
		    'Reply-To: '.$from."\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message
		$message = '<html><body>';
		$message .= '<h1 style="color:#f40;">You Have A New Order From Website</h1>';
		$message .= '<p style="color:#080;font-size:18px;">Order Id- '.$OrderId;
		$message .= '</p></body></html>';
		 
		// Sending email
		if(mail($to, $subject, $message, $headers)){
		    echo 'Your mail has been sent successfully.';
		} else{
		    echo 'Unable to send email. Please try again.';
		}

		// this section send mail to customer
		$mailbody="Dear Customer(s),\n
		Thank you for placing an order at www.balaskolkata.com \n
		Your order no is ".$OrderId."\n
		Please log in to www.balaskolkata.com to track your order status.\n
		Looking forward to serve you again.\n\n

		Thanks & Regards,\n
		Balas Team\n
		Kolkata\n
		(+91) 91634 88628\n
		Look Good! Do Good.'
		";

		$by ='From: orders@balaskolkata.com'."\r\n".
         'Reply-To: orders@balaskolkata.com'."\r\n" .
          'X-Mailer: PHP/' . phpversion();

		mail($txtEmail, "Thank you for placing an order at www.balaskolkata.com", $mailbody, $by);

			echo "<script>window.open('payment_success.php?name=T3JkZXIgU3VjZXNz','_self');</script>";
		}
	}
}


//function to add new review
function createreview($product_id,$title,$details,$rate)
{
	global $con;
	$sql="INSERT INTO `product_review`(`product_id`, `review_by(email)`, `review_by(name)`, `title`, `details`, `rate`) VALUES ('".mysqli_real_escape_string($con,$product_id)."','".mysqli_real_escape_string($con,$_SESSION['UserEmail'])."','".mysqli_real_escape_string($con,$_SESSION['UserFullName'])."','".mysqli_real_escape_string($con,$title)."','".mysqli_real_escape_string($con,$details)."','".mysqli_real_escape_string($con,$rate)."')";
	if($con->query($sql) === true){
					echo "
					<div class='alert alert-success alert-dismissible' role='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					  <strong>success!</strong> Review Added.
					</div>

					";
				}
}
?>