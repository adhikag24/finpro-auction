<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users Management</li>
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
                              
                            </h5>
                           <?= $this->session->userdata('message'); ?>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                         <th>#</th>
                                        <th>Full Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; foreach($members as $row): $i++ ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?=$row['member_name']?></td>
                                        <td><?=($row['role'] == 1) ? "Admin" : "User"?></td>
                                        <td><?=$row['member_email']?></td>
                                       
                                        <td>
                                            <div class="btn-group">
                                                <a  data-toggle="modal" data-target="#exampleModal" data-id="<?= $row['member_id']?>" href="#!"
                                                    class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                <a href="<?=base_url()?>admin/delete_user/<?=$row['member_id']?>"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?=base_url()?>admin/update_user">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">New Fullname:</label>
            <input type="text" id="member_name" name="member_name" class="form-control">
          </div>
          <input type="hidden" id="user_id" name="member_id">
          <div class="form-group">
            <label for="message-text" class="col-form-label">New Email:</label>
            <input type="text" name="member_email" id="member_email" class="form-control required">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send message</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
 
 $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var id = button.data('id') 

  var modal = $(this)
  modal.find('#user_id').val(id)
})

</script>