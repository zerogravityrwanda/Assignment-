<?php 

      $bla=new mysqli("localhost","root","","classA");
      if (isset($_GET['phone_number'])) {
      	$phone_number=$_GET['phone_number'];
      	$sele=$bla->query("SELECT*FROM information where phone_number='$phone_number'");
      	while($row=mysqli_fetch_array($sele)){
      		$firstname=$row['firstname'];
      		$lastname=$row['lastname'];
      		$gender=$row['gender'];
      		$province=$row['province'];

      	}
      }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Information</title>
	<style>
		/* Reset and base styles */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body {
			font-family: Arial, sans-serif;
			background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
			min-height: 100vh;
			padding: 20px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
		/* Container for the form */
		form {
			background: white;
			max-width: 500px;
			width: 100%;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.2);
		}
		
		/* Form title */
		form::before {
			content: "Update Information";
			display: block;
			font-size: 28px;
			font-weight: bold;
			color: #333;
			margin-bottom: 30px;
			text-align: center;
		}
		
		/* Input fields */
		input[type="text"] {
			width: 100%;
			padding: 12px;
			margin: 8px 0 15px 0;
			border: 2px solid #e0e0e0;
			border-radius: 5px;
			font-size: 14px;
			transition: border-color 0.3s;
		}
		
		input[type="text"]:focus {
			outline: none;
			border-color: #1e3c72;
		}
		
		/* Submit button */
		button {
			width: 100%;
			padding: 12px;
			background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
			color: white;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			font-weight: bold;
			cursor: pointer;
			transition: transform 0.2s;
			margin-top: 10px;
		}
		
		button:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0,0,0,0.3);
		}
		
		/* Responsive design */
		@media (max-width: 768px) {
			form {
				padding: 30px 20px;
			}
		}
	</style>
</head>
<body>
	<form method="post">
	firstname:<input type="text" name="fn" placeholder="firstnames" value="<?php echo$firstname?>"><br>
	lastname:<input type="text" name="ln" placeholder="lastname" value="<?php echo$lastname?>"><br>
 		gender:<input type="text" name="gender" placeholder="gender" value="<?php echo$gender?>"><br>
 		province:<input type="text" name="province" placeholder="province" value="<?php echo$province?>"><br>
 		<button type="submit" name="update"> update </button>
</form>
<?php
if (isset($_POST['update'])) {
	$firstname=$_POST['fn'];
	$lastname=$_POST['ln'];
	$gender=$_POST['gender'];
	$province=$_POST['province'];
	$up=$bla->query("UPDATE information set firstname='$firstname',lastname='$lastname',gender='$gender',province='$province' where phone_number='$phone_number'");
	if ($up)
		 {
             			header("location:index.php");
             		}
					else {

	echo "goodz";
	}
}
         

 ?>
</body>
</html>