<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Price Logs</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3><i class="icons icon-edit"></i></h3>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($logs)): ?>
                    <table class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Market</th>
                                <th>No of Entries</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= ucfirst($log->first_name) . ' ' . ucfirst($log->last_name); ?></td>
                                    <td><?= ucfirst($log->market_name); ?></td>
                                    <td><?= ucfirst($log->entry); ?></td>
                                    <td>
                                        <a href="<?= site_url('/user/view_plog_details/' . $log->market_id . '/' . $log->added_by); ?>" title="Click here to view details">
                                            View details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>