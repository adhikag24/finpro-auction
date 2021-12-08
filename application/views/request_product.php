<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-8">
            <?= $this->session->flashdata('message'); ?>
            <div class="card rounded shadow">
                <div class="card-header">
                    Request Product
                </div>
                <div class="card-body">
                    <?= form_open_multipart(base_url('product/insertproduct')) ?>
                    <div class="mb-3">
                        <label for="" class="form-label">Product Name</label>
                        <input type="text" class="form-control" value="<?php echo set_value('product_name'); ?>" name="product_name" required>
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Starting Price</label>
                        <input type="number" class="form-control" value="<?php echo set_value('starting_price'); ?>" name="starting_price" required>
                        <?= form_error('starting_price', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Bidding Time</label>
                        <input type="text" name="daterange" class="form-control" value="<?= date("m/d/Y") ?> - <?= date("m/d/Y") ?>" />
                        <!-- <input type="date" class="form-control"  value="<?php echo set_value('daterange'); ?>" placeholder="yyyy-mm-dd hh:mm:ss" name="end_date" required> -->
                        <?= form_error('daterange', '<small class="text-danger pl-3">', '</small>') ?>

                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Product Images</label>
                        <input type="file" name="product_image" class="form-control">
                    </div>
                    <button class="btn btn-outline-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            showDropdowns: true,
            minYear: 2021,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var currentDate = <?= date("Y-m-d") ?>;
            console.log(start.format('YYYY-MM-DD') + ' < '+ currentDate);
            if (start.format('YYYY-MM-DD') < currentDate) {
                alert("You can only choose date after today.");
                $('input[name="daterange"]').val('');
            }
            console.log("Current Date ", currentDate)
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>