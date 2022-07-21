<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	
    <style>
	body {
		background-image: linear-gradient(#b5c1e6, white);
	}
    </style>
  </head>



<body>
<?php include('header.php'); ?>
<br/><br/><br/><br/><br/>
<div class="row border col-6 d-flex justify-content-center align-items-center mx-auto" 
style="backdrop-filter:blur(200px);border-radius:20px;background-color: rgba(255, 255, 255, 0.183);box-shadow: 0px 0px 15px 1px rgba(0,0,0,0.08);"> 

    <div class="col-6 d-flex justify-content-center align-items-center flex-column">
        <br/>
        <h1>Donate</h1>
        <form action="Donate_Amount.php" class="col-8" method="post" enctype="multipart/form-data">
        <br/>

        <?php
            $donation_amountErr = $allErr = "";

            //connect database
            $dbc = mysqli_connect('localhost', 'root', 'newinti2020');
            mysqli_select_db($dbc, 'savfood');
			

            if (isset($_POST['submitted'])) {

                if (isset($_SESSION['cust_id'])) {
				$cust_id = $_SESSION['cust_id'];
                $donation_amount = $_POST['amount'];
                $okay = true;
            
                if (empty($donation_amount)) {
                $allErr = "* Please fill out all the field.<br/><br/>";
                $okay = false;
                }

                else {
                    //phone number validation
                    if (empty($donation_amount)) {
                    $donation_amountErr = "* Amount is required";
                    $okay = false;				
                    }
                    else if (!is_numeric($donation_amount)) {
                    $donation_amountErr = "* Only digits are allowed";
                    $okay = false;
                    }
                        else if (strlen($donation_amount)<1) {
                            $donation_amountErr = "* Amount is invalid";
                            $okay = false;
                        }
                        
                }

                if ($okay) {
                    $query = "INSERT INTO donation (donation_id, donation_amount, donation_datetime, cust_id)
                                VALUES (0, '$donation_amount', now(), $cust_id)";
                        
                        if (mysqli_query($dbc, $query)){
        ?>                
                            <script>
                                window.setTimeout(function(){
                                window.location.href = 'Donate_Receipt.php';
                                }, 100);
                            </script>
        <?php
                            }
                            else {
                                echo "Fail to donate because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
                            }
                }
    

            //close the database
                mysqli_close($dbc);
        }   
        else {
			?>
			<script>
			alert("Please login to your account before donate the money.");
			window.location.href = 'userlogin.php';
			</script>
			<?php
		}

        }
        
        ?>
        
            <div class="row mb-2">
                <div class="col">
                <input type="text" class="form-control" name="amount" placeholder="Amount" required>
                <br/>
                <select name="Payment" class="form-select">
                    <option selected>TNG eWallet</option>
                    <option>Credit Card</option>
                </select>
                </div>
            </div>	

            <br/>
        <a href="Receipt.php">
        <div class="col-12 d-flex justify-content-center">
            <input type="submit" value="Donate" class="btn btn-primary text-light">   
			<input type="hidden" name="submitted" value="true">
        </div></a>
        <br/>
        <p style= "text-align:center;"><a href="Donate.php">Go Back!</a></p>
        </form>
        <br/><br/>
    </div>
</div>
<br/><br/><br/>
    <?php include "Footer.php"?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>