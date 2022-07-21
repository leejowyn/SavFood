<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
<style>
    .accordion-button:not(.collapsed) {
    color: #ffffff; 
    background-color: #bbc5e6;
    box-shadow: inset 0 -1px 0 rgb(0 0 0 / 13%); 
}
</style>
</head>

<body>
<?php 
$page = "customerService";
include('header.php'); 
?>
<div class="col-9 mx-auto">
<br/><br/>
    <h1 class="fw-bolder">Frequently Asked Questions</h1>
	<br/><br/>
    <p>FAQs for SavFood and SavFood Merchant-Partners</p>

    <p>We understand that during these uncertain times, many of our Merchant-Partners are relying more on delivery services. Therefore, we are constantly evaluating how we operate to maximize sales and returns on our platform for our Merchant-Partners.</p>
    <div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
    <li>Why is it that sometimes my outlet is not visible in the Website but other outlets in other areas near mine are visible to the same customer?</li>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <p>This could be because the service radius of Merchant-Partners in your area has been reduced due to a shortage of delivery-partners in the area. Merchant-Partners in the slightly further area might still be visible to you because there are more available delivery-partners there.</p>

        <p>Differences in weather conditions and demand patterns by areas contribute to this difference. For example, if it has been raining in Bangsar but not in TTDI, Merchant-Partners in TTDI will be more widely visible to customers.</p>

        <p>Similarly, if there is a significant order increase from Halal outlets in Sentul resulting in a shortage of Halal delivery-partners, the base service radius of only Halal outlets in Sentul will be reduced; non-Halal outlets may still be visible to customers.</p>

        <p><strong>Service radius adjustment by area and halal / non-halal delivery fleet</strong>ensure we do not unnecessarily reduce any Merchant-Partner's radius.</p>
    </div>
        </div>
    </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <li>How does SavFood determine the service radius for Merchant-Partners?</li>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <p>All SavFood Merchant-Partners have a starting base service radius of 7-10 KM from the location of the outlet (note that this radius is calculated using estimated driving distances and may vary from distance shown in-Website). Small and medium (SME) Merchant-Partners who do not have vast outlet coverage have a bigger service radius than the starting base to help maximize their service coverage in the city.</p>
      <p>This service radius range applies during most times, except in the following situations:</p>
      <ol>
      <li><strong>Rainy weather</strong> affecting delivery-partners’ ability to travel.</li>
      <li><strong>Any other unforeseen circumstances resulting in a shortage of delivery-partners</strong> in certain areas.</li>
      </ol>
      <p>In such cases, we estimate a lower likelihood of being able to assign Merchant-Partners a delivery-partner. Hence, there may be a gradual reduction in service radius for Merchant-Partners in the affected area to avoid disappointing customers with significantly long wait times and reduce food wastage. Merchant-Partners’ service radius will be gradually restored to the base service radius as our delivery fleet recovers.</p>

      <p>Note that we <strong>never</strong> selectively pause or turn off any Merchant-Partners in situations where there is a shortage of delivery-partners.</p>

      <p>*SavFood is constantly evaluating how we can maximize fulfillment and sales for our merchant-partners. Therefore, we would be testing a slightly different automated system from time to time. Rest assured that we are committed to doing our best to support you and your business on our platform.</p>
  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         <li>What can Merchant-Partners do to influence the base radius?</li>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <p>We always strive to provide Merchant-Partners with the maximum possible service radius. However, this depends on a range of factors: the size of our delivery fleet in an area, time spent by delivery-partners waiting for each order, and the ability of delivery-partners to deliver each order within a reasonable time.</p>
        <p>Merchant-Partners can help influence the general base radius in an area by, <strong>reducing delivery-partner wait time in store</strong> so each delivery-partner can complete more orders thus lowering the possibility of a shortage of delivery-partners in peak hours. Some tips include regularly monitoring the SavFoodMerchant Website to ensure no orders are missed, ensure your notification settings are at an optimal level, optimize your meal preparation time to prevent any delays, and have your outlet staff on standby to ensure the meals are packed and passed on to our delivery-partners efficiently.</p>
    </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="Four">
        <li>Why is my outlet sometimes paused inside my SavFoodMerchant Website with the “Incoming Orders Paused” message, especially when my restaurant is very busy?</li>
      </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <p>We monitor for long waiting times and large concentrations of our delivery bikers and drivers at outlets for pending orders.</p>

        <p>When we believe your outlet might be struggling to cope with a very large amount of pending orders, we would take the precaution of temporarily pausing your store (usually for about 10 minutes) so that you do not receive more orders to add to the backlog. Please see the screenshot below to identify such situations.</p>

        <p>However, please note that if your staff is confident in dealing with the number of pending orders, they <strong>can always immediately unpause</strong> your store from the SavFoodMerchant Website. This can be achieved by pressing the resume button or hitting the pause toggle.</p>

    </div>
    </div>
  </div>
</div>

</div>
<?php include "Footer.php"?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>