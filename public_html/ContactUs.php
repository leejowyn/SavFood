<!DOCTYPE html>
<html>
<head>

	<title>Contact Us</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">

	<style>
     .successbg {
        position: absolute;
        width: 15vw;
        height: 10vh;
        display: center;
        top:30%;
        Left : 700px;
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
    
    </style>
</head>

<body>
<?php include('header.php'); ?>
<?php 
    if (isset($_POST['submitted'])) {
        $name = ($_POST['name']);
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];
        $msg = $_POST['msg'];
        $okay = true;

        if (empty($name) && empty($email) && empty($phoneno) && empty($msg)) {
			echo "Please fill out all the field.<br/><br/>";
			$okay = false;
		}
        else {
            if (empty($name)) {
				echo "First Name is required.<br/><br/>";
				$okay = false;
			}
            else if (ctype_alpha(str_replace(' ', '', $name)) == false) {
				echo "Only letters and spaces are allowed in Name field.<br/><br/>";
                $okay = false;
			}

            if (empty($email)) {
				echo "Email is required.<br/><br/>";	
                $okay = false;		
			}
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid E-mail address.<br/><br/>";
                $okay = false;
            }
            
            if (empty($phoneno)) {
				echo "Phone Number is required.<br/><br/>";			
                $okay = false;
			}
			else if (!is_numeric($phoneno)) {
				echo "Only digits are allowed.<br/><br/>";
                $okay = false;
			}
            else if (strlen($phoneno)==11 && substr($phoneno, 0, 3)!="601") {
                echo "Phone number is invalid.<br/><br/>";
                $okay = false;
            }
            else if (strlen($phoneno)==12 && substr($phoneno, 0, 4)!="6011") {
                echo "Phone number is invalid.<br/><br/>"; 
                $okay = false; 
            }
            else if (strlen($phoneno)!=11 && strlen($phoneno)!=12) {
                echo "Length of phone number is invalid.<br/><br/>";
                $okay = false;
            }

            if (empty($msg)) {
                echo "Message is required.";
                $okay = false;
            }
        }
        if ($okay) {
                            
                $curl = curl_init();

                $postfields = array(
                    "m_name" => $name,
                    "m_email" => $email,
                    "m_phone" => $phoneno,
                    "m_comment" => $msg
                );

                $postfields = json_encode($postfields);

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://localhost/SavFood/api/message/create.php',
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

                if ($response->success) {
            
                    
                        echo '
                            <div class="successbg">
                                <div class="success-signup">
                                    <h1>Successfull!</h1>
                                    <p>Your message has been sent successfully.</p>
                                    <br/><br/>
                                    <a href="homepage.php"><button class="btn btn-primary text-light">Yay!</button></a>    
                                </div>
                            </div>
                        '; 
            
                }
                else {
                echo '
                    <div class="successbg">
                        <div class="success-signup">
                            <h1>Fail</h1>
                            <p>Your message fail to send</p>
                            <br/><br/>
                        </div>
                    </div>
                '; 
                }
                     

            // //connect database
            // $dbc = mysqli_connect('localhost', 'root', '');
            // mysqli_select_db($dbc, 'savfood');
    
            // $query = "INSERT INTO message (message_id, m_name,m_email,m_phone,m_comment)
            // VALUES (0,'$name', '$email','$phoneno','$msg')";
            
    
            // if (mysqli_query($dbc, $query)) {
            
                    
            //     echo '
            //         <div class="successbg">
            //             <div class="success-signup">
            //                 <h1>Successfull!</h1>
            //                 <p>Your message has been sent successfully.</p>
            //                 <br/><br/>
            //                 <a href="homepage.php"><button class="btn btn-primary text-light">Yay!</button></a>    
            //             </div>
            //         </div>
            //     '; 
    
            //  }
            //  else {
            //     echo '
            //         <div class="successbg">
            //             <div class="success-signup">
            //                 <h1>Fail</h1>
            //                 <p>Your message fail to send</p>
            //                 <br/><br/>
            //             </div>
            //         </div>
            //     '; 
            //  }
            
            // //close database
            // mysqli_close($dbc);
        }
        }
?>

<form action="ContactUs.php" class="d-flex align-items-center flex-column px-3" method="post">
            <br/><br/>
            <h1 style="text-align:center">Contact Us</h1>
            <br/>

            <div class="col-sm-6  mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Name">
            </div>

            <div class="col-sm-6 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            <div class="col-sm-6  mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                <input type="phone" name="phoneno" class="form-control" id="exampleFormControlInput1" placeholder="Phone Number">
            </div>

            <div class="col-sm-6 mb-3 form-floating"> 
                <label for="exampleFormControlInput1" class="form-label">Comments</label>
                <textarea class="form-control" name="msg" placeholder="Leave a message" id="floatingTextarea2" style="height: 100px"></textarea>
            </div>

            <br/>

            <div class="d-flex justify-content-center mx-auto">
                <button class="btn btn-primary text-light" style="box-shadow: -1px 9px 15px 1px rgba(143,159,209,0.66);width:200px" type="submit" >Send</button>
                <input type="hidden" name="submitted" value="true">
            </div>
    </form>
<?php

include 'Footer.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>