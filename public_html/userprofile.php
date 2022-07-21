<!DOCTYPE html>
<html>
<head>

	<title>SavFood</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">
    <style>
        body {
          background-repeat: no-repeat;
          background-position: center;
          background-size: cover;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
      .text{
        width:20%
      }
      .text1{
        margin-left: 40%;
      }
      @media (max-width: 380px) {
  .text{
    width:50%;
  }
  .text1{
    margin-left: 20%;
  }
}
        </style>
    </head>
	
	<body>
  <?php include "header.php"?>
		

		<div class="container" style="width: 50%;">
			<br>
			<h2 class="text1">Profile</h2>
			<br><br><br><br>

			<div id="Edit Details" class="tabcontent">
				<h3>Edit Details</h3>
				<br>
				<?php
					$msg = "";
				
					if (isset($_SESSION['customer_info'])) {
						$okay = true;
						mysqli_select_db($dbc, 'savfood');

						if ($r = mysqli_query($dbc, $_SESSION['customer_info'])) { 
							$row = mysqli_fetch_array($r);
							
							$id = $row['cust_id'];
							$firstname = $row['cust_fname'];
							$lastname = $row['cust_lname'];
							$phone = $row['cust_phone'];
							$email = $row['cust_email'];
							$pw = $row['cust_password'];
						}
					
					
					if( isset($_POST['update']))	{
						$firstname = $_POST['cust_fname'];
						$lastname = $_POST['cust_lname'];
						$phone = $_POST['cust_phone'];
						$email = $_POST['cust_email'];
                        $pw = $row['cust_password'];
		
						$curl = curl_init();
						
						$postfields = array(
							"cust_fname" => $firstname,
							"cust_lname" => $lastname,
							"cust_phone" => $phone,
							"cust_email" => $email,
							"cust_password" => $pw,
							"cust_id" =>$id,
						);
				  
						$postfields = json_encode($postfields);
						curl_setopt_array($curl, array(
						CURLOPT_URL => 'http://localhost/SavFood/api/customer/update.php',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS =>$postfields,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: text/plain'
						),
						));

						$response = curl_exec($curl);
						$response = json_decode($response);
						$response;
						curl_close($curl);

						if ($response->success) {
							echo "Your profile has been updated successfully!";
						} 
						else {
							echo $response->customer;
						}
					}
				}
				?>	
				 <?php
                        if(isset($_POST['delete']))	{

						$curl = curl_init();

						curl_setopt_array($curl, array(
						CURLOPT_URL => 'http://localhost/SavFood/api/customer/delete.php',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS =>'{
							"cust_id":'.$id.'
						}',
						CURLOPT_HTTPHEADER => array(
							'Content-Type: text/plain'
						),
						));

						
						$response = json_decode(curl_exec($curl));
						curl_close($curl);

						if ($response->success) {
							echo "Your profile has been updated successfully!";
						} 
						else {
							echo $response->customer;
						}
					}
				?>	     
				
				<form action="userprofile.php" method="post">

					<div class="form-group">
						<label for="firstname">Firstname</label>
						<input value="<?php echo $firstname; ?>" type="text" class="form-control" name="cust_fname" required>
					</div>

					<div class="form-group">
						<label for="lastname">Lastname</label>
						<input value="<?php echo $lastname; ?>" type="text" class="form-control" name="cust_lname" required>
					</div>
					  
					<div class="form-group">
						<label for="phone">Phone</label>
						<input value="<?php echo $phone; ?>" type="text" class="form-control" name="cust_phone" required>
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input value="<?php echo $email ?>" type="email" class="form-control" name="cust_email" required>
					</div>

                    <div class="form-group">
						<label for="pw">Password</label>
						<input value="<?php echo $pw ?>" type="pw" class="form-control" name="cust_password" required>
					</div>
					
					<br>
					<div class="col-12 d-flex justify-content-center">
   					 <input type="submit" value="update" class="btn btn-primary text-light" name="update" style="text;box-shadow: -1px 8px 12px 1px rgba(143,159,209,0.66);">
   					 </div>
					 <br/><br/>
					 <div class="col-12 d-flex justify-content-center">
   					 <input type="submit" value="delete" class="btn btn-primary text-light" name="delete" style="text;box-shadow: -1px 8px 12px 1px rgba(143,159,209,0.66);">
   					 </div>
					<br>
					<br>

				</form>
			</div>
		</div>
		<hr>
		
		
     <?php include "Footer.php"?>
	
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	</body>
</html>