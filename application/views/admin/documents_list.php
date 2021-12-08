<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Documents Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Documents Request List</li>
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
                            <h5 class="m-0 text-dark">Documents List
                              
                            </h5>
                           
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                         <th>#</th>
                                        <th>Author</th>
                                        <th>Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i =0; foreach($documents as $row): $i++ ?>
                                    <tr>
                                    <?php
                                    $name = $this->db->get_where('member',['member_id'=>$row['user_id']])->row_array()['member_name'];
                                    ?>
                                        <td><?= $i; ?></td>
                                        <td><?= $name ?></td>
                                        <td> <a href="<?=base_url()?>/assets/document/<?= $row['newsdoc_name'] ?>"
                                                    class="btn-lg btn-primary" target="_blank"><i class="fas fa-file-alt"></i></a></td>
                                    <td><div class="btn-group">
                                                <a href="<?=base_url()?>admin/delete_document/<?=$row['newsdoc_id']?>"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </div></td>

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