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
                        <th>Current Highest Bid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $i): ?>
                    <tr>
                        <td><?= $i['name'] ?></td>
                        <td><?= $i['amount'] ?></td>
                        <td><?= $i['starting_price'] ?></td>
                        <td><?= $i['highest_bid'] ?></td>
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