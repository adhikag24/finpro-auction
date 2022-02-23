<!-- <div class="container mt-5 mb-5">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-6 border-end">
                <div class="d-flex flex-column justify-content-center">
                    <div class="main_image"> <img src="" id="main_product_image" width="350"> </div>
                    <div class="thumbnail_images">
                        <ul id="thumbnail">
                            <img src="" width="70">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 right-side">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 id="product_name"></h3> <span class="heart"><i class='bx bx-heart'></i></span>
                    </div>
                    <div class="mt-2 pr-3 content">
                        <h5>Starting Price: Rp.<span id="starting_price"> </span></h5>
                    </div>
                    <h4>Current Highest Bid: </h4>
                    <h3>Rp.<span id="highest_bid"> </span></h3>
                    <div class="ratings d-flex flex-row align-items-center">
                        <div class="d-flex flex-row"> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i
                                class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bx-star'></i> </div>
                        Total Bidder:<span id="total_bidder"> </span>
                    </div>
                    <div class="mt-3">
                        <div id="countDownDiv" data-countdown="">

                        </div>
                    </div>
                    <div class="buttons d-flex flex-row mt-5 gap-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                            Bid Now
                        </button>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div> -->



<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1">  <div class="main_image"> <img src="" id="main_product_image" width="300"> </div></div>
						</div>
						<ul class="preview-thumbnail nav nav-tabs">
						
						</ul>
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title" id="product_name"></h3>
						<p class="product-description" id="description"></p>
						<h5 class="price">Highest Bid: Rp.<span id="highest_bid"></span></h5>
						<h5 class="price">Starting Price: Rp.<span id="starting_price"></span></h5>
						<p class="vote"><strong id="total_bidder"></strong> of bidders, place a bid!</p>
            <?php if(empty($userBid)):?>
            <p class="vote">Your Bid In this product: <strong>Rp.</strong><strong id="user_bid">0</strong></p>
            <?php else: ?>
              <p class="vote">Your Bid In this product: <strong>Rp.</strong><strong id="user_bid"><?=number_format($userBid['amount'])?></strong></p>
              <?php endif;?>
            <div class="action">
							<button class="add-to-cart btn btn-default" type="button" data-toggle="modal" data-target="#exampleModal">Bid Now</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Place a Bid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form ref="form">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Bid</label>
                        <div class="col-sm-10">
                            <input type="number" name="amount" class="form-control" id="totalbid">
                        </div>
                    </div>
                    <input type="hidden" id="productid" name="productid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" id="submitBid">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="module">
import {
    onValue,
    productRef,
    database,
    ref
} from '<?php echo base_url(); ?>js/script3.js'

const productDetailRef = ref(database, 'products/<?= $id ?>');

function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

onValue(productDetailRef, (snapshot) => {
    var data = snapshot.val();
    $("#main_product_image").attr('src', data.product_images + "?alt=media");
    $("#product_name").html(data.product_name);
    $("#description").html(data.description);
    $("#starting_price").html(numberWithCommas(data.initial_price));
    $("#starting_price").val(data.initial_price);
    $("#highest_bid").html(numberWithCommas(data.highest_bid));
    $("#highest_bid").val(data.highest_bid);
    $("#total_bidder").html(data.total_bidder);
    $("#productid").val(data.product_id);
    $('#countDownDiv').data('countdown', data.end_date)

    $('[data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');

        var countDownDate = new Date(finalDate).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            $this.html(days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ");

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                $this.html("EXPIRED");
            }
        }, 1000);
    });
});
</script>

<script>
// function onBid(){
//     console.log("submit bid");
//     $.ajax({
//         type: 'GET',
//         url: <?=base_url()?>+'product/test',
//         success: function(data){
//             console.log('success',data);
//         }
//     });
// }
$(document).ready(function() {

  function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    

    $("#submitBid").click(function() {
        var amount = $('#totalbid').val();
        var productid = $('#productid').val();
        var currentprice = $('#starting_price').val();
        var highestprice = $('#highest_bid').val();
        var fbid ="<?=$id?>"
        console.log("amount",amount)
        console.log("current price",currentprice)
        if (amount <= currentprice || amount <= highestprice) {
            alert("Amount, can't be lower than current price")
        } else {
            $.post("<?=base_url()?>product/submitbid", {
                amount: amount,
                productId: productid,
                productfbId: fbid
            }, function(data, status) {
                console.log(data);
                const obj = JSON.parse(data.toString())
                if (obj.code == 200) {
                    $("#user_bid").html(numberWithCommas(amount));
                    alert("Success Submit Bid");
                    
                } else {
                    alert(obj.message);
                }
            });
        }


    });
});
</script>


<style>
    
/*****************globals*************/
body {
  overflow-x: hidden; }

img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.price {
    font-weight: bolder;
}

.checked, .price span {
    font: weight 700px;}

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: brown;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

/*# sourceMappingURL=style.css.map */
</style>