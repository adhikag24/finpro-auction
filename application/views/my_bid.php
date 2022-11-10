<div class="container mt-5">
    <h3 class="mb-3">Bid List</h3>
    <div class="card">
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Your Bid</th>
                        <th>Starting Price</th>
                        <th>Product Highest Bid</th>
                        <th>Bid Status</th>
                        <th>Product Owner Contact</th>
                        <th>Bid History</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $i): ?>
                    <tr>
                        <td><?= $i['name'] ?></td>
                        <td>Rp.<?= number_format($i['amount']) ?></td>
                        <td>Rp.<?= number_format($i['starting_price']) ?></td>
                        <td>Rp.<?= number_format($i['highest_bid']) ?></td>
                        <td><?= $i['status'] ?></td>
                        <td><?= $i['product_owner_info'] ?></td>
                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Bid History
</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bid History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Your Recent Bid
      <ul class="list-group">
      <?php foreach($data[0]['history'] as $i): ?> 
  <li class="list-group-item"><?= number_format($i['amount']) ?> - <?= $i['created_at'] ?> </li>
                       
                    <?php endforeach; ?>
</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>