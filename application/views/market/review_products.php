<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/market/pending_approval') ?>">
            <i class="icons icon-chevron-left"></i> Back</a>
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
<br>


<div class="row-fluid">
        <div class="well">
            <form method="post" class="form-horizontal">

                <div class="span12 ">
                    
                    <input required name="start_date" type="text" placeholder="Start Date" class="datepick" style="cursor: pointer" value="<?php if($start_date): echo $start_date;  endif; ?>" />
                    &nbsp;
                    <input required name="end_date" type="text" placeholder="End Date" class="datepick" style="cursor: pointer" value="<?php if($end_date): echo $end_date;  endif; ?>" />
                    &nbsp;
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?= $this->uri->segment(4) ?> Products 
                </h3>
            </div>
            <div class="box-content nopadding">
                <?php
                if (!empty($pending_approvals)) :
                    ?>

                    <table class="table table-hover table-nomargin table-striped dataTable dataTable-reorder">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Date</th>
                                <th class='hidden-1024'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_approvals as $pending) : ?>
                                <tr>
                                    <td>
                                        <strong><?= ucfirst($pending->product_name) ?></strong></td>
                                   
                                    <td>
                                        <?= date('d-M-Y', strtotime($pending->market_date)); ?>
                                    </td>
                                    <td>
                                        <a title="Click here to approve" class="approve" href="<?= site_url('/market/approve_prices/' . $pending->market_id . '/' . $pending->product_id); ?>">Approve</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No product found');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade modal-full" id="modal_view_prices" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="myModalLabel">View Prices</h4>
</div>
    <div id="modalcontent">
        
    </div>
</div>

<script>
    $('body').delegate('.view', 'click', function (evt) {
        evt.preventDefault();
        
        var market_ = $(this).data('market_name');
        var product_name_ = $(this).data('product_name');

        $('#modal_view_prices').modal('show');
        $('#myModalLabel').text('Prices of ' + product_name_ + ' at ' + market_ + ' Market');
        $('#modalcontent').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

        var page = $(this).attr("href");
        $.get(page, function (html) {

            $('#modalcontent').html('');
            $('#modalcontent').html(html);
            $('#modalcontent').modal('show').fadeIn();
        });
        return false;
    });

    $(function () {
        $('body').delegate('.approve', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to approve prices for this market?';
            CTM.doConfirm({
                title: 'Approve',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
</script>