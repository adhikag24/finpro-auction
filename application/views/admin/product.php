<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product Management</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <!-- /.card-header -->

                        <div class="card-header">
                            <h5 class="m-0 text-dark">Product List
                                <div class="float-right">
                                    <a href="<?= base_url() ?>admin/syncproductbid"  onclick="return confirm('This Button will run function to validate all bid winner and send the notification. Are you sure?');" class="btn btn-sm btn-warning"><i class="fa fa-sync"></i> Validate Products</a>
                                </div>
                            </h5>

                        </div>
                        <div class="card-body">
                            <?= $this->session->userdata('message'); ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Starting Price</th>
                                        <th>End Date</th>
                                        <th>Is Approved</th>
                                        <th>Total Bidder</th>
                                        <th>Highest Bid</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($data as $i) : ?>
                                        <tr>
                                            <td><?= $i['name'] ?></td>
                                            <td><?= $i['starting_price'] ?></td>
                                            <td><?= $i['end_date'] ?></td>
                                            <td><?php if ($i['is_active'] == 1) : ?>
                                                    <span class="badge badge-success">Approved</span>
                                                <?php elseif ($i['is_active'] === '0') : ?>
                                                    <span class="badge badge-danger">Not Approved</span>
                                                <?php else : ?>
                                                    <span class="badge badge-warning">Checking In Progress</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php if ($i['total_bidder'] == 0 || $i['total_bidder'] == null) : ?>
                                                    0
                                                <?php else : ?>
                                                    <?= $i['total_bidder'] ?>
                                                <?php endif; ?>
                                            </td>


                                            <td><?php if ($i['highest_bid'] == 0 || $i['highest_bid'] == null) : ?>
                                                    0
                                                <?php else : ?>
                                                    <?= $i['highest_bid'] ?>
                                                <?php endif; ?>
                                            </td>

                                            <td> <img class="img" src="<?= $i['product_image'] ?>?alt=media" alt="" width="50" height="50"> </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>