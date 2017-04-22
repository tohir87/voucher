<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Batch <?= $batch_id; ?></h1>
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
                    Pin Codes
                </h3>
                <div class="btn-group pull-right" style="margin-right: 5px">
                    <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">Print <span class="caret"></span></a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?= site_url('/print/'. $batch_id .'/10') ?>">10 Per Page</a>
                        </li>
                        <li>
                            <a href="<?= site_url('/print/'. $batch_id .'/20') ?>">20 Per Page</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($pins)): ?>
                    <table class="table table-striped table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Pin Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pins as $pin):
                                ?>
                                <tr>
                                    <td><?= $pin->pin_serial; ?></td>
                                    <td><?= $pin->pin_code; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No pin was found');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>