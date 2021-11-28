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
                                <input type="text" class="form-control"  value="<?php echo set_value('product_name'); ?>" name="product_name" required>
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                               <div class="mb-3">
                                <label for="" class="form-label">Starting Price</label>
                                <input type="number" class="form-control"  value="<?php echo set_value('starting_price'); ?>" name="starting_price" required>
                                <?= form_error('starting_price', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                               <div class="mb-3">
                                <label for="" class="form-label">End Date</label>
                                <input type="date" class="form-control"  value="<?php echo set_value('end_date'); ?>" placeholder="yyyy-mm-dd hh:mm:ss" name="end_date" required>
                                <?= form_error('end_date', '<small class="text-danger pl-3">', '</small>') ?>
                            
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