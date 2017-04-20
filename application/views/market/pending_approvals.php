<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">
        <h1>Pending Approvals</h1>
    </div>
</div>
<div class="breadcrumbs">
    <ul>
        <li><a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a><i class="icon-angle-right"></i></li>
        <li><a href="#">Markets</a><i class="icon-angle-right"></i></li>
        <li><a href="#">Pending Price Approval</a></i></li>
    </ul>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Markets
                </h3>
            </div>
            <div class="box-content nopadding">
                <?php
                if (!empty($markets)) :
                    ?>

                    <table class="table table-hover table-nomargin table-striped dataTable dataTable-reorder">
                        <thead>
                            <tr>
                                <th>Market</th>
                                <th class='hidden-1024'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($markets as $market) : ?>
                                <tr>
                                    <td>
                                        <strong><?= ucfirst($market->market_name) ?></strong></td>
                                                                       
                                    <td>
                                        <a title="Click here to view products" class="view" href="<?= site_url('/market/view_market_products/' . $market->market_id . '/' . $market->market_name); ?>">View Products</a>                                       
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No markets found');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>