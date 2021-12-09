<div class="container">
    <div class="container-fluid justify-content-center">
        <div class="row mt-5" id="productCardSection">
            <?php foreach ($data as $i) { ?>
                <div class="col-sm-3">
                    <div class="card"> <img src="https://i.imgur.com/z55ax9e.jpeg" class="card-img-top img-fluid img-thumbnail" width="100%">
                        <div class="card-body pt-0 px-0">
                            <div class="mt-3 text-center"><?= $i['name'] ?></div>

                            <div class="d-flex flex-row justify-content-between mb-0 mt-3 px-3"> <span class="text-muted mt-1">Starting At:</span>
                                <h6>Rp.<?= $i['starting_price'] ?></h6>
                            </div>
                            <hr class="mt-2 mx-3">
                            <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                <div class="d-flex flex-column"><span class="text-muted">Highest Bid:</span></div>
                                <div class="d-flex flex-column">
                                    <h6>Rp.<?= $i['highest_bid'] ?></h6>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                <div class="d-flex flex-column"><span class="text-muted">Total Bidder:</span></div>
                                <div class="d-flex flex-column">
                                    <h6><strong><?= $i['total_bidder'] ?></strong></h6>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-between px-3 pb-2">
                                <div class="d-flex flex-column"><span class="text-muted">Status:</span></div>
                                <div class="d-flex flex-column">
                                    <?= "Bid Is Finished" ?>
                                </div>
                            </div>

                            <div class="mx-2 mt-3 mb-2"><a href="#" type="button" class="btn btn-<?= ($i['winner_announced'] == 1) ? 'success' : 'info' ?> btn-block disabled"><small>
                                       <?= ($i['winner_announced'] == 1) ? 'Bid Winner, has been announced.' : 'Bid Winner, still in checking process.' ?>
                            </small></a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    </div>
</div>
</div>