<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	
    <style>
	body {
		background-image: linear-gradient(#b5c1e6, white);
	}

      input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}

    .successbg {
        position: absolute;
        width: 15vw;
        height: 10vh;
        display: center;
        top:30%;
        Left : 600px;
        justify-content: center;
        align-items: center;
        z-index: 3;
      }

      .success-signup {
        position: absolute;
        width: 400px;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        backdrop-filter:blur(200px);
        background-color: rgba(800, 800, 300, 0.364);
        border-radius:20px;
        z-index: 3;
      }
      .media{
        height:400px;
      }
      
      @media (max-width: 380px) {
    .media{
         height:150px;
       }
      }

    </style>

<body>
<?php include "header.php"?>
 <?php

	$pwErr = $emailErr =  "";
	$okay = true;
	
	    if (isset($_POST['submitted'])) {
        $email = $_POST['email'];
        $pw = $_POST['pw'];

       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "* Invalid E-mail address";
                $okay = false;
            }
      

      if ($okay) {
                //connect database
                $dbc = mysqli_connect('localhost', 'root', 'newinti2020');
                mysqli_select_db($dbc, 'savfood');

                //retrieve and check whether this email and password is exist
                $query = "SELECT * FROM restaurant WHERE restaurant_email = '$email'";

              if ($result = mysqli_query($dbc, $query)) {
                  if (mysqli_num_rows($result) == 0) {
                      $emailErr = "* Couldn't find that E-mail address. Check the spelling and try again.";
                      $okay = false;
                   }
           else {
                   $query = "SELECT * FROM restaurant WHERE restaurant_email='$email' AND restaurant_password=MD5('$pw')";
                   $okay=true;
						
						if ($r = mysqli_query($dbc, $query)) {
							$row = mysqli_fetch_array($r);
							
							if (isset($row)) {
								$_SESSION['rest_id'] = $row['restaurant_id'];
								$_SESSION['restaurant_info'] = "SELECT * FROM restaurant WHERE restaurant_email ='$email'"; 
                echo '
                            <div class="successbg">
                                <div class="success-signup">
                                    <h1>Welcome Back!</h1>
                                    <p>We are happy to have you on board. </p>
                                    <br/><br/>
                                    <a href="restaurantstatus.php"><button class="btn btn-primary text-light">Yay!</button></a>    
                                </div>
                            </div>
                        '; 
							}
							else {
								$pwErr = "The password that you've entered is incorrect. Please try again.";
								$okay = false;
							}
						}          
        }
           }
                else {
                    echo "Fail to login because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
                }
				
			//close the database
			mysqli_close($dbc);
    
  
     }
  }
  ?>

<br/><br/><br/><br/><br/>
<div class="row border col-lg-7 d-flex justify-content-center align-items-center mx-auto" 
style="border-radius:20px;box-shadow: -1px 1px 30px 2px rgba(143,159,209,0.44);"> 

    <div class="col-sm-12 col-lg-6 p-5 d-flex justify-content-center align-items-center" style="background:rgba(255, 255, 255, 0.583);border-radius:20px">
      <img src="img/restaurant_login.png" class="media">
    </div>
    <div class="col-6 d-flex justify-content-center align-items-center flex-column">
      <br/>
    <h1>Login - Restaurant</h1>
  	<form action="restaurantlogin.php" method="post" enctype="multipart/form-data">
        <br/><br/>
        <div class="col-12 mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <span style="color:#e80909"><?php echo $emailErr; ?></span>
          </div>
          <div class="col-12 mb-3">
            <input type="password" class="form-control" name="pw" placeholder="Password" required>
            <span style="color:#e80909"><?php echo $pwErr; ?></span>
        </div>
    <br/><br/>
    <div class="col-12 d-flex justify-content-center">
    <input type="submit" value="Login" class="btn btn-primary text-light" style="box-shadow: -1px 9px 14px 1px rgba(143,159,209,0.66);">
        <input type="hidden" name="submitted" value="true">
    </div>

      <br/><br/>
    </form>
    </div>
    </div>
	<br/><br/>
    <?php include "Footer.php"?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>
