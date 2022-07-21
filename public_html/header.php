<?php
if (!isset($page)) {
	$page = "";
}
?>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #bbc5e6;">
        <div class="col-11 container-fluid">
			<div class="col-1 me-1"></div>
			<div class="col-5">
            <a class="navbar-brand" href="homepage.php"><img src="img/savfood_logo.png" class="p-1" width="28%"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
			</div>
            <div class="col-6 ps-5 ms-5">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-2">
                            <a class="nav-link <?php echo ($page == "home" ? "active" : "")?>" aria-current="page" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link <?php echo ($page == "restaurantsResult" ? "active" : "")?>" href="restaurantsResult.php">Restaurant</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link <?php echo ($page == "donate" ? "active" : "")?>" href="donate.php">Donation</a>
                        </li>
						<li class="nav-item me-2">
                            <a class="nav-link <?php echo ($page == "aboutUs" ? "active" : "")?>" href="aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item dropdown me-3">
							<a class="nav-link <?php echo ($page == "customerService" ? "active" : "")?> dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Customer Service</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="contactus.php">Contact Us</a></li>
								<li><a class="dropdown-item" href="faq.php">FAQ</a></li>
							</ul>
						</li>
						<li class="nav-item me-3">
                            <a href="cart.php">
								<i class="fa fa-shopping-cart position-relative" style="font-size:25px; color:black;">
									
									<?php
										$dbc = mysqli_connect('localhost', 'root', 'newinti2020');

										if (!$dbc) {
											die("Error: " . mysqli_connect_error($dbc));
										}

										//select the database
										mysqli_select_db($dbc, 'savfood');
										
										session_start();
										
										if (isset($_POST['logout'])) {
											session_destroy();
											?>
											<script>
											window.location.href = 'userlogin.php';
											</script>
											<?php
										}
										
										if (isset($_SESSION['cust_id'])) {
											$cust_id = $_SESSION['cust_id'];
											$query = "SELECT * FROM cart WHERE cust_id = $cust_id AND qty > 0";
											
											if ($r = mysqli_query($dbc, $query)) {
												$cart_count = mysqli_num_rows($r);
												echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger" style="font-family:system-ui, -apple-system, Segoe UI;font-size:10px" id="cart_badge">'.$cart_count.'</span>';
											}
											else {
												echo mysqli_error($dbc) . "The query was: " . $query;
											}
										}
									?>
									
								</i>
							</a>
                        </li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa fa-user" style="font-size:25px; color:black;"></i></a>
							<ul class="dropdown-menu" style="left: -100px;">
							<?php
							if (isset($_SESSION['cust_id'])) {
								echo '
								<li><a class="dropdown-item" href="userprofile.php">User Profile</a></li>
								<li><a class="dropdown-item" href="orderhistory.php">Order History</a></li>
								<li><a class="dropdown-item" href="DonateHistory.php">Donate History</a></li>
								<li><hr class="dropdown-divider"></li>
								<li>
									<form action="homepage.php" method="post">
										<input class="dropdown-item" type="submit" value="Logout">
										<input type="hidden" name="logout" value="true">
									</form>
								</li>
								';
							}
							else {
								echo '
								<li class="ms-3 mt-1 mb-1">Login As :</li>
								<li><a class="dropdown-item" href="userlogin.php">User</a></li>
								<li><a class="dropdown-item" href="restaurantlogin.php">Restaurant</a></li>
								';
							}
							?>
							</ul>
						</li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

