<div class="container">
    <div class="container-fluid justify-content-center">
        <div class="row mt-5" id="productCardSection">




        </div>
    </div>
</div>

<script type="module">
    import {
        onValue,
        productRef
    } from '<?php echo base_url(); ?>js/script.js'

    onValue(productRef, (snapshot) => {
        var data = snapshot.val();
        var html = "";
        for (var val in data) {
            console.log(val);

            html += `
                <div class="col-sm-3" >
                    <div class="card"> <img src="https://i.imgur.com/z55ax9e.jpeg" class="card-img-top img-fluid img-thumbnail" width="100%">
                                <div class="card-body pt-0 px-0">
                                    <div class="mt-3 text-center" >${data[val].product_name}</div>

                                    <div class="d-flex flex-row justify-content-between mb-0 mt-3 px-3"> <span class="text-muted mt-1">Starting At:</span>
                                        <h6>Rp.${data[val].initial_price}</h6>
                                    </div>
                                    <hr class="mt-2 mx-3">
                                    <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                        <div class="d-flex flex-column"><span class="text-muted">Highest Bid:</span></div>
                                        <div class="d-flex flex-column">
                                            <h6>Rp.${data[val].highest_bid}</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                        <div class="d-flex flex-column"><span class="text-muted">Total Bidder:</span></div>
                                        <div class="d-flex flex-column">
                                            <h6><strong>${data[val].total_bidder}</strong></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                        <div class="d-flex flex-column"><span class="text-muted">Time Left:</span></div>
                                        <div class="d-flex flex-column" data-countdown="${data[val].end_date}">
                                            0d 0h 0m 0s
                                        </div>
                                    </div>
                                    <div class="mx-3 mt-3 mb-2"><a href="<?=base_url()?>product/detail/${data[val].product_id}" type="button" class="btn btn-danger btn-block"><small>
                                                Detail
                                    </small></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

        }

        $('#productCardSection').empty();
        $('#productCardSection').html(html);

        $('[data-countdown]').each(function() {
            console.log("hihiih");
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

        console.log(data);
    });
</script>