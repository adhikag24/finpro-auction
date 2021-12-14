<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bid Winner Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Bid Winner Management</li>
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
                            <h5 class="m-0 text-dark">Bid Winner List
                           
                            </h5>
                            <?= $this->session->userdata('message'); ?>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Highest Bid</th>
                                        <th>Starting Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $i) : ?>
                                        <tr>
                                            <td><?= $i['user_name'] ?></td>
                                            <td><?= $i['name'] ?></td>
                                            <td><?= number_format($i['highest_bid']) ?></td>
                                            <td><?= number_format($i['starting_price']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
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

<script>
function myFunction() {
  confirm("Press a button!");
}
</script>