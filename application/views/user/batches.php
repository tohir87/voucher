<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Batches</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-bar-chart"></i>
                    ---
                </h3>
                <a href="#" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                    <i class="icons icon-plus-sign"></i> Download Batch
                </a>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($batches)): ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Provider</th>
                                <th>Date Added</th>
                                <th>Time Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn = 0;
                            foreach ($batches as $batch):
                                ?>
                                <tr>
                                    <td><?= ++$sn; ?></td>
                                    <td><?= $batch->provider_name; ?></td>
                                    <td><?= date('d-M-Y', strtotime($batch->batch_date)); ?></td>
                                    <td><?= date('h:i:A', strtotime($batch->batch_time)); ?></td>
                                    <td>
                                        <a href="/view_pins/<?= $batch->batch_id; ?>">
                                            <i class="icons icon-print"></i> View Pins</a>
                                    </td>
                                </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No Batch has been uploaded.');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>