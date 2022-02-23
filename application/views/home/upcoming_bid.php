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

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    onValue(productRef, (snapshot) => {
        var data = snapshot.val();
        var html = "";
        for (var val in data) {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + '-' +  mm + '-' + dd;

            var d1 = Date.parse(data[val].end_date);
            var d2 = Date.parse(today);
            var d3 = Date.parse(data[val].start_date);
            console.log(data);
            


            if (d3 >= d2){//jika end date belum melewati hari ini dan start date sudah terlewat
                html += `
                <div class="col-sm-3" >
                    <div class="card"> <img src="${data[val].product_images}?alt=media" class="card-img-top img-thumbnail" style="width: 300px; height: 300px; object-fit:cover;">
                                <div class="card-body pt-0 px-0">
                                    <div class="mt-3 text-center" >${data[val].product_name}</div>

                                    <div class="d-flex flex-row justify-content-between mb-0 mt-3 px-3"> <span class="text-muted mt-1">Starting At:</span>
                                        <h6>Rp.${numberWithCommas(data[val].initial_price)}</h6>
                                    </div>
                                    <hr class="mt-2 mx-3">
                                    <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                        <div class="d-flex flex-column"><span class="text-muted">Bid will start:</span></div>
                                        <div class="d-flex flex-column" data-countdown="${data[val].start_date}">
                                            0d 0h 0m 0s
                                        </div>
                                    </div>
                                    <div class="mx-3 mt-3 mb-2"><a href="<?= base_url() ?>product/detail/${val}" type="button" class="btn btn-danger btn-block disabled"><small>
                                                Wait until the bid started
                                    </small></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
            }


        }

        $('#productCardSection').empty();
        $('#productCardSection').html(html);

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
                    $this.html("Bid Is Started");
                }
            }, 1000);
        });

        console.log(data);
    });
</script>