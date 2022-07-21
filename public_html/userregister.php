  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Register - User</title>
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
        Left : 700px;
        top:35%;
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
        background-color: rgba(800, 800, 700, 0.364);
        border-radius:20px;
        z-index: 3;
      }
      .media{
        height:350px;
      }
      
      @media (max-width: 380px) {
  .media{
    height:150px;
  }
}
      </style>
    </head>

  <body>
  <?php 
  $page = "";
  include "header.php";

  $firstname = $lastname = $phoneno = $email = $pw = $cpw = "";
  $firstnameErr = $lastnameErr = $emailErr = $pwErr = $cpwErr= $allErr = "";

    //connect database
    $dbc = mysqli_connect('localhost', 'root', 'newinti2020');
    mysqli_select_db($dbc, 'savfood');

  if (isset($_POST['submitted'])) {
    
    $firstname = ucwords(strtolower($_POST['firstname']));
    $lastname = ucwords(strtolower($_POST['lastname']));
    $phoneno = $_POST['phoneno'];
    $email = $_POST['email'];
    $pw = $_POST['pw'];
    $cpw = $_POST['cpw'];

    //password validation
    $number = preg_match('@[0-9]@', $pw);
    $upperCase = preg_match('@[A-Z]@', $pw);
    $lowerCase = preg_match('@[a-z]@', $pw);
    $specialChars = preg_match('@[^\w]@', $pw);
    
    $okay = true;
    
      //first name validation
       if (!ctype_alpha(str_replace(' ', '', $firstname))) {
        $firstnameErr = "* Only letters and spaces are allowed";
        $okay = false;
      }
      
      //last name validation
      if (!ctype_alpha(str_replace(' ', '', $lastname))) {
        $lastnameErr = "* Only letters and spaces are allowed";
        $okay = false;
      }
      
      //email validation
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "* Invalid E-mail address";
                $okay = false;
            }
      else {
                $query = "SELECT * FROM customer WHERE cust_email = '$email'";

                if ($result = mysqli_query($dbc, $query)) {
                    if (mysqli_num_rows($result) == 1) {
                        $emailErr = "* Email address is already in use.";
                        $okay = false;
                    }
                }
                else {
                    echo 'Error: '.mysqli_error($dbc);
                }
            }
      
      //password validation
     if (strlen($pw) < 8 || !$number || !$upperCase || !$lowerCase || !$specialChars) {
                $pwErr = "* Password must be at least 8 characters in length and must containat least one number, one upper case letter, one lower case letter and one special character.";
                $okay = false;
            
              }
         
    //confirm password
    else if ($_POST["pw"] != $_POST["cpw"]) {
      $okay=FALSE;
      echo"<p>Your password not match!</p>";
     }
      
    if ($okay ) {
         $curl = curl_init();

         $postfields = array(
          "cust_fname" => $firstname,
          "cust_lname" => $lastname,
          "cust_phone" => $phoneno,
          "cust_email" => $email,
          "cust_password" => $pw
      );

      $postfields = json_encode($postfields);

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost/SavFood/api/customer/create.php',
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
        curl_close($curl);
        
        // $query = "INSERT INTO customer (cust_id, cust_fname, cust_lname, cust_phone, cust_email, cust_password)
        // VALUES (0, '$firstname', '$lastname','$phoneno', '$email', ('$pw'))";
    
       if($response->success) {

        echo '
        <div class="successbg">
        <div class="success-signup">
            <h1>Hi ' . $firstname . ' ' . $lastname .'!</h1>
            <h1>Welcome to Savfood!</h1>
            <p>We are happy to have you on board. </p>
            <a href="userlogin.php"><button class="btn btn-primary text-light">Great!</button></a>  
        </div>
        </div>
          ';
      }
    }

    }

    //close the database
        mysqli_close($dbc);
    
  ?>
  <br/><br/><br/><br/><br/>
  <div class="row border col-7 d-flex justify-content-center align-items-center mx-auto" 
  style="border-radius:20px;box-shadow: -1px 1px 30px 2px rgba(143,159,209,0.44);"> 

      <div class="col-sm-12 col-lg-6 p-5 d-flex justify-content-center align-items-center" style="background:rgba(255, 255, 255, 0.583);border-radius:20px">
        <img src="img/u_register.png" class="media">
      </div>

  <div class="col-sm-3 col-lg-6 d-flex justify-content-center align-items-center flex-column">
      <br/><br/>
      <h1>Register - User</h1>
	  <br/>
      <form action="userregister.php" class="col-8" method="post" enctype="multipart/form-data">
      <br/>
        <div class="row mb-2">
          <div class="col">
            <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $firstname;?>"required>
            <span style="color:#e80909"><?php echo $firstnameErr; ?></span>
          </div>
          <div class="col">
            <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $lastname;?>"required>
            <span style="color:#e80909"><?php echo $lastnameErr; ?></span>
          </div>
      </div>	

      <div class="col-12 mb-2">
          <input type="number" class="form-control" name="phoneno" placeholder="Phone Number" value="<?php echo $phoneno;?>"required> 
      </div>

      <div class="col-12 mb-2">
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>"required>
          <span style="color:#e80909"><?php echo $emailErr; ?></span>
      </div>
      <div class="col-12 mb-2">
          <input type="password" class="form-control" name="pw" placeholder="Password" value="<?php echo $pw;?>"required>
          <span style="color:#e80909"><?php echo $pwErr; ?></span>
      </div>
      <div class="col-12 mb-2">
          <input type="password" class="form-control" name="cpw" placeholder="Confirm Password" value="<?php echo $cpw;?>"required>
          <span style="color:#e80909"><?php echo $cpwErr; ?></span>
      </div>

	<br/>
    <div class="col-12 d-flex justify-content-center">
    <input type="submit" value="Register" class="btn btn-primary text-light" style="box-shadow: -1px 8px 12px 1px rgba(143,159,209,0.66);">
        <input type="hidden" name="submitted" value="true">
    </div>

    </br>
    <p class="small text-center"> Already have an account? <a href="userlogin.php">Login</a></p>
    </form>
	<br/>
  </div>
  </div>
  <br/><br/>
  <?php include "Footer.php"?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
  </html>