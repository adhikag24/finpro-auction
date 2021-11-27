<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-8">

                <div class="card rounded shadow">
                    <div class="card-header">
                        Request Product
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="onUpload()">
                            <div class="mb-3">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" class="form-control" v-model="transaction.product_name">
                               
                            </div>
                               <div class="mb-3">
                                <label for="" class="form-label">Starting Price</label>
                                <input type="number" class="form-control" v-model="transaction.starting_price">
                        
                            </div>
                               <div class="mb-3">
                                <label for="" class="form-label">End Date</label>
                                
                                <input type="date" class="form-control" placeholder="yyyy-mm-dd hh:mm:ss" v-model="transaction.end_date">
                            
                            </div>
                              <div class="mb-3">
                                <label for="" class="form-label">Product Images</label>
                                <input type="file" name="imagesArray[]" class="form-control" multiple @change="onChange">
                            </div>
                            <button class="btn btn-outline-primary">Submit</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>