<div class="container mt-5">
    <h3 class="mb-3">Product List</h3>
    <div class="card">
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Starting Price</th>
                        <th>Start Date</th>
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
                            <td><?= number_format($i['starting_price']) ?></td>
                            <td><?= $i['start_date'] ?></td>
                            <td><?= $i['end_date'] ?></td>
                            <td><?php if ($i['is_active'] == 1) : ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php elseif ($i['is_active'] === '0' && $i['is_validated'] == 1) : ?>
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
                                    <?= number_format($i['highest_bid']) ?>
                                <?php endif; ?>
                            </td>

                            <td> <img class="img" src="<?=$i['product_image']?>?alt=media" alt="" width="50" height="50"> </td>
                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            "ordering": false
        });
    });
</script>