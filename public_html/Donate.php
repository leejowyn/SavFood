<!DOCTYPE html>
<html>
<head>

	<title>Donate</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">


    <body>
<?php 
$page = "donate";
include('header.php'); 
?>
<br/><br/><br/><br/>

<div class="row border col-7 d-flex justify-content-center align-items-center mx-auto" 
style="backdrop-filter:blur(200px);border-radius:20px;background-color: rgba(255, 255, 255, 0.183);box-shadow: 0px 0px 15px 1px rgba(0,0,0,0.08);"> 

    <div class="col-10 d-flex justify-content-center align-items-center flex-column">   
        <br/>
        <form action="Donate.php" class="col-12" method="post" enctype="multipart/form-data">
        <br/>

<?php
			$dbc = mysqli_connect("localhost",'root','newinti2020','savfood');

			if(!$dbc) {
				die("Unable to connect" . mysqli_error($connection));
			}

				if (isset($_SESSION['donation'])) {
					$login = true;
					mysqli_select_db($dbc, 'savfood');
				}
		?>

  <h1 style="text-align:center">Donation</h1>
  <br/>
  <p>We launced this donation feature for allowing customers to donate to those in need. Your donation of money help 3 million child out of hunger. Donate to a cause that feeds thousands everyday.</p>
    
    <br/>
    
    <div class="d-flex justify-content-center mx-auto">
      <a href="Donate_Amount.php"><button class="btn btn-primary text-light" style="box-shadow: -1px 9px 15px 1px rgba(143,159,209,0.66);width:200px" type="button" >Donate</button></a>
    </div>
    <br/>

  <hr/>

  <br/>
  <h1 style="text-align:center">Donation Amount</h1>
  <br/>
  
  <?php
  $query = "SELECT MAX(donation_amount) AS highest_amount FROM donation";
	
	if ($r = mysqli_query($dbc, $query)) { 
		$row = mysqli_fetch_array($r);
		$highest_amount = number_format($row['highest_amount'], 2);
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}
  
  echo'<div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="text-align:center;" >Highest Donation</h5>
          <p class="card-text" style="text-align:center;"> RM '.$highest_amount.'</p>
        </div>
      </div>
    </div>';

  ?>

<?php
  $query = "SELECT SUM(donation_amount) AS all_amount FROM donation";
	
	if ($r = mysqli_query($dbc, $query)) { 
		$row = mysqli_fetch_array($r);
		$all_amount = number_format($row['all_amount'],2);
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}

    echo'<div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title" style="text-align:center;">Total Donation</h5>
          <p class="card-text" style="text-align:center;"> RM '.$all_amount.'</p>
        </div>
      </div>
    </div>   
  </div>
  <br/>
</div>
</div>';
?>

<br/>
   <?php include "Footer.php"?> 
</body>
</html>
