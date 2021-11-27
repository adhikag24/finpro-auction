<div class="container mt-5">
    <h3 class="mb-3">Product List</h3>
    <div class="card">
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Starting Price</th>
                        <th>End Date</th>
                        <th>Is Approved</th>
                        <th>Total Bidder</th>
                        <th>Highest Bid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $i) : ?>
                        <tr>
                            <td><?= $i['name'] ?></td>
                            <td><?= $i['starting_price'] ?></td>
                            <td><?= $i['end_date'] ?></td>
                            <td><?= $i['is_active'] ?></td>
                            <td><?php if ($i['total_bidder'] == 1) : ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php elseif ($i['total_bidder'] == 0) : ?>
                                    <span class="badge badge-danger">Not Approved</span>
                                <?php else : ?>
                                    <span class="badge badge-warning">Checking In Progress</span>
                                <?php endif; ?>
                            </td>
                            
                            <td><?php if ($i['highest_bid'] == 0 || $i['highest_bid'] == null) : ?>
                                    0
                                <?php else : ?>
                                    <?= $i['highest_bid'] ?>
                                <?php endif; ?>
                            </td>
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