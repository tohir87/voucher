<?= show_notification();
?>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <h1>Setup</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="box">
    <div class="box-content nopadding">
        <?php include APPPATH . 'views/setup/_setup_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Markets
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_market')): ?>
                                    <a href="#new_market" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                        <i class="icons icon-plus-sign"></i> New Market
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($markets)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>Market</th>
                                                <th>Location</th>
                                                <th>State</th>
                                                <th>Product Count</th>
                                                <th>Status</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_market')): ?>
                                                    <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($markets as $market):
                                                ?>
                                                <tr>
                                                    <td><?= $market->market_name; ?></td>
                                                    <td><?= $market->location ?></td>
                                                    <td>
                                                        <?= $market->StateName ?>
                                                    </td>
                                                    <td>
                                                        <?= $market->p_count ?>
                                                    </td>
                                                    <td>
                                                        <span class="label label-<?= $market->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$market->status] ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:edit_market')): ?>
                                                        <td>
                                                            <a title="Click here to edit this market" class="edit_market" href="<?= site_url('/market/edit_market/' . $market->market_id) ?>"> <i class="icons icon-edit"></i> Edit</a> |
                                                            <a title="Click here to change market status" class="Toggle" data-enabled='<?= $market->status ?>' href="<?= site_url('/market/changeMarketStatus/' . $market->market_id . '/' . $market->status) ?>"><?= $market->status ? 'Disable' : 'Enable'; ?></a> |
                                                            <a title="Click here to delete this market" class="delete_market" href="<?= site_url('/market/delete_market/' . $market->market_id) ?>"> 
                                                                <i class="icons icon-trash"></i>    Delete
                                                            </a>|
                                                            <a title="Click here to view products of this market" href="<?= site_url('/setup/markets/products/' . $market->market_id) ?>">  Products</a> 
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No market found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_market.php'; ?>

    <div class="modal hide fade" id="modal_edit_market" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>

<script>
    $(function () {
        $('body').delegate('.delete_market', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this market ?';
            CTM.doConfirm({
                title: 'Confirm Delete',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });

    $(function () {
        $('body').delegate('.Toggle', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = parseInt($(this).data('enabled')) ? 'If you disable this market, you \'ll no longer be able to compute price from it, Are you sure you want to continue? ' : 'Are you sure you want to enable this market ?';
            CTM.doConfirm({
                title: 'Confirm Status Change',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });

    $('body').delegate('.edit_market', 'click', function (evt) {
        evt.preventDefault();

        $('#modal_edit_market').modal('show');
        $('#modal_edit_market').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

        var page = $(this).attr("href");
        $.get(page, function (html) {

            $('#modal_edit_market').html('');
            $('#modal_edit_market').html(html);
            $('#modal_edit_market').modal('show').fadeIn();
        });
        return false;
    });
    $('body').delegate('.edit_market', 'click', function (evt) {
        evt.preventDefault();

        $('#modal_edit_market').modal('show');
        $('#modal_edit_market').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

        var page = $(this).attr("href");
        $.get(page, function (html) {

            $('#modal_edit_market').html('');
            $('#modal_edit_market').html(html);
            $('#modal_edit_market').modal('show').fadeIn();
        });
        return false;
    });
    
</script>