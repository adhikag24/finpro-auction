<div class="container mt-5 mb-5">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-6 border-end">
                <div class="d-flex flex-column justify-content-center">
                    <div class="main_image"> <img :src="product.product_images" id="main_product_image" width="350"> </div>
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
                        <div class="d-flex flex-row"> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bx-star'></i> </div>Total Bidder:<span id="total_bidder"> </span>
                    </div>
                    <div class="mt-3">
                        <vue-countdown :time="time" :interval="100" v-slot="{ days, hours, minutes, seconds }">
                            Time Left: {{ days }}d {{ hours }}h {{ minutes }}m {{ seconds }}s
                        </vue-countdown>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" onclick="onBid()">Submit</button>
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

    onValue(productDetailRef, (snapshot) => {
        var data = snapshot.val();
        console.log(data);
        console.log(data.product_name);
        $("#product_name").html(data.product_name);
        $("#starting_price").html(data.initial_price);
        $("#highest_bid").html(data.highest_bid);
        $("#total_bidder").html(data.total_bidder);
    });

    
</script>

<script>
    function onBid(){
        console.log("submit bid")
    }
</script>