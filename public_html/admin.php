<?php
$realm = 'Restricted area';

//user => password
$users = array('admin' => 'mypass');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('Text to send if user hits Cancel button');
}


// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Wrong Credentials!');


// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Wrong Credentials!');

// ok, valid username & password
echo 'You are logged in as: ' . $data['username'];


// function to parse the http auth header
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta-charset="UTF-8">
	<title>Admin</title>
	<link href="sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
	<style>
		@media (max-width: 380px){
			.container-fluid{
					max-width: 20px;
			}
		}
		</style>
</head>

<body>
	<?php
		include ('admin_sidebar.html');
		
		$dbc = mysqli_connect("localhost",'root','newinti2020','savfood');

		if(!$dbc) {
			die("Unable to connect" . mysqli_error($connection));
		}
		
		session_start();
	?>
	
	<div class="main-content">
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" style="margin:20px">
				<div class="container-fluid">
					<br/>
					
					<h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>
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
					  
					  echo'
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Highest Donation</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$'.$highest_amount.'</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
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

						echo'
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Donation</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$'.$all_amount.'</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
					?>

                    <?php
					  $query = 'SELECT COUNT(restaurant_id) AS approved_restaurant FROM restaurant WHERE restaurant_status = "Approved"';
						
						if ($r = mysqli_query($dbc, $query)) { 
							$row = mysqli_fetch_array($r);
							$approved_restaurant = $row['approved_restaurant'];
						}
						else {
							echo mysqli_error($dbc) . "The query was: " . $query;
						}

						echo'
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Approved Restaurant</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.$approved_restaurant.'</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
					?>

					<?php
					  $query = 'SELECT COUNT(restaurant_id) AS pending_restaurant FROM restaurant WHERE restaurant_status = "Pending"';
						
						if ($r = mysqli_query($dbc, $query)) { 
							$row = mysqli_fetch_array($r);
							$pending_restaurant = $row['pending_restaurant'];
						}
						else {
							echo mysqli_error($dbc) . "The query was: " . $query;
						}

						echo'
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Restaurant</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.$pending_restaurant.'</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
					?>

				</div>
			</div>
		</div>
	</div>
	
</body>
</html>
