<?= show_notification();
$genders = [0 => '', 1 => "Female", 2 => "Male"];
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Market Traders</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="box">
    <div class="box-content nopadding">

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Traders
                                </h3>
                                <a href="<?= site_url('/setup/add_trader') ?>" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> Add New Trader
                                </a>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($traders)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Phone</th>
                                                <th>Markets</th>
                                                <th style="width: 30%">Products</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sn = 0;
                                            foreach ($traders as $trader):
                                                ?>
                                                <tr>
                                                    <td><?= ++$sn; ?></td>
                                                    <td><?= ucfirst($trader->first_name . ' ' . $trader->last_name) ?> <br>
                                                        <span class="muted"><?= $supply_chains[$trader->metric_type]; ?></span>
                                                    </td>
                                                    <td><?= $genders[$trader->gender_id] ?></td>
                                                    <td><?= $trader->phone ?></td>
                                                    <td><?= $trader->market_name ?></td>
                                                    <td>
                                                        <?php
                                                        if (!empty($trader->products)):
                                                            foreach ($trader->products as $prod):
                                                                echo "<span class='label'>{$prod} </span>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= site_url('/setup/edit_trader/' . $trader->trader_id);?>"> 
                                                            <i class="icons icon-edit"></i>edit
                                                        </a> | 
                                                        <a class="delete_trader" href="<?= site_url('/setup/deleteTrader/' . $trader->trader_id); ?>"> 
                                                            <i class="icons icon-trash"></i>delete
                                                        </a> 
                                                    </td>

                                                </tr>
    <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No trader has been added');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Assign market modal -->
<div class="modal hide fade" id="modal_assign_market" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >

</div>

<div class="modal hide fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

<script>
    $(function () {
        $('body').delegate('.delete_trader', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this trader ?';
            CTM.doConfirm({
                title: 'Confirm Delete',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
</script>