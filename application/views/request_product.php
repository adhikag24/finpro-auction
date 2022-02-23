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
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Product Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="product_description"rows="3" required>
                        <?php echo set_value('product_description'); ?>
                        </textarea>
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
                        <label for="" class="form-label">Product Image</label>
                        <input type="file" name="product_image" class="form-control">
                    </div>

                    <div class="mb-3">
                    <div class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Product Image Rules!</div>
                    </div>


                    <button class="btn btn-outline-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Image Rules</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <ul class="list-group">
        <li class="list-group-item">The product image is clear, and not blurry.</li>
        <li class="list-group-item">The background of the product image must be in plain (white) background.</li>
        <li class="list-group-item">There must be only the product object in the image.</li>
        </ul>
        <div class="mt-3 mb-3"><strong>Example of accepted image:</strong></div>
        <img src="https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/iphone-contoh1643545327.jpeg?alt=media" alt="..." width="200px" class="img-thumbnail">
        <img src="https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/19155531639215747.jpg?alt=media" alt="..." width="200px" class="img-thumbnail">
        <img src="https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/image_(1)1644417927.jpg?alt=media" alt="..." width="200px" class="img-thumbnail">
        <img src="https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/black-tshirt1643547530.jpg?alt=media" alt="..." width="200px" class="img-thumbnail">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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