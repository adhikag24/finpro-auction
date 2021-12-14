<div class="container mt-5 mb-5">
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
                    <!-- <div class="buttons d-flex flex-row mt-5 gap-3"> <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">Bid Now</button></div> -->
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

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Place a Bid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form ref="form">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Bid</label>
                        <div class="col-sm-10">
                            <input type="number" name="amount" v-model="bid.amount" class="form-control" id="totalbid">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" v-on:click="submitBid">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

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
    console.log(data);
    console.log(data.product_name);
    $("#main_product_image").attr('src', data.product_images + "?alt=media");
    $("#product_name").html(data.product_name);
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
    

    $("#submitBid").click(function() {
        var amount = $('#totalbid').val();
        var productid = $('#productid').val();
        var currentprice = $('#starting_price').val();
        var highestprice = $('#highest_bid').val();
        var fbid ="<?=$id?>"
        console.log("masuk", amount);
        console.log("masuk", currentprice);
        console.log("masuk", highestprice);
        if (amount <= currentprice || amount <= highestprice) {
            alert("Amount, can't be lower than current price")
        } else {
            $.post("<?=base_url()?>product/submitbid", {
                amount: amount,
                productId: productid,
                productfbId: fbid
            }, function(data, status) {
                if (status == "success") {
                    alert("Success Submit Bid");
                } else {
                    alert("Something Wrong Happen, Fail Submit Bid");
                }
                console.log(data, status);
            });
        }


    });
});
</script>