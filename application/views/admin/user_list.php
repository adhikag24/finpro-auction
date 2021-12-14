<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bid Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
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
                            <h5 class="m-0 text-dark">Users List
                            <div class="float-right">
                                    <a href="<?=base_url()?>bid/syncbidwinner" onclick="return confirm('This Button will run function to validate all bid winner and send the notification. Are you sure?');" class="btn btn-sm btn-warning"><i class="fa fa-sync"></i> Sync Bid Winner</a>
                                </div>
                            </h5>
                            <?= $this->session->userdata('message'); ?>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $i) : ?>
                                        <tr>
                                            <td><?= $i['user_name'] ?></td> 
                                            <td><?= $i['user_email'] ?></td>
                                            <td><?= ($i['role'] == 0) ? "Member" : "Admin"  ?></td>
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