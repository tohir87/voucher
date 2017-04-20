<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/user/view_price_logs') ?>"> <i class="icons icon-chevron-left"></i> Back</a>
        <h1>Price Log Details</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3><i class="icons icon-edit"></i>
                <?= ucfirst($logs[0]->first_name) . ' ' . ucfirst($logs[0]->last_name); ?>
                </h3>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($logs)): ?>
                    <table class="table table-bordered table-condensed table-striped table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Market</th>
                                <th>Product</th>
                                <th>Source/Variety</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= ucfirst($log->market_name); ?></td>
                                    <td><?= ucfirst($log->product_name); ?></td>
                                    <td>
                                        <?= $log->source; ?>
                                        <?php
                                        if (isset($log->variety)):
                                            echo '/' . $log->variety;
                                        endif;
                                        ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($log->date_added)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>