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
        .carousel-item {
 background-color: black;
        }
        .carousel-item > img {
            height: 70%;
            object-fit: cover;
           opacity:0.5;
        }
        </style>
</head>

<body>
<?php 
$page = "aboutUs";
include "header.php"
?>
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
      <img src="img/f1.jpg" class="d-block w-100 carousel-img" alt="...">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>FAQ</h1>
            <p>If you have other questions please inform us.</p>
            <p><a class="btn btn-primary text-light" href="FAQ.php">Read More</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
          <img src="img/f2.jpg" class="d-block w-100 carousel-img" alt="...">
        <div class="container">
          <div class="carousel-caption">
            <h1>Contact Us</h1>
            <p>Don't be hesitate to contact us, our staff will reply you as soon as possible.</p>
            <p><a class="btn btn-primary text-light" href="ContactUs.php">Contact us</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
      <img src="img/f3.1.jpg" class="d-block w-100 carousel-img" alt="...">
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>Donate</h1>
            <p>If you are interested to make donation press here. We are so gratefull with your donation for the people suffer with hunger.</p>
            <p><a class="btn btn-primary text-light" href="Donate.php">Donate here</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
	<hr class="col-11 mx-auto"/><br/>
    <div class="col-9 mx-auto mt-5 mb-5">
        <h2 style="text-align:center">Problem Statement</align></h2><br/><br/>
        <p>Malaysians are producing way too much food wastage these days. The food wastage is increasing each year. According to The Star Newspaper 17,000 out of 38,000 tonnes of domestic daily waste are considered as food waste, out of which estimated 4,080 tonnes which are still edible. 
            These 4,080 tonnes are enough to feed 3 million people for 3 meals per day.</p>
        <p>Besides that, putting food waste in landfills adds to environmental damage and global warming.  This is due to the emission of methane gas during the decomposition process, which is a greenhouse gas that is more dangerous than carbon dioxide. It will also spread diseases by allowing insects and pests to breed, 
            as well as raise landfill management expenses.</p>
    </div>

<br/>
<?php include "Footer.php"?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

