<?= show_notification();?>

<div class="page-header">
    <div class="pull-left">
        <h1>Remarks</h1>
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
                                    Remarks
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_remark')): ?>
                                <a href="#add_remark" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> New Remark
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($remarks)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Remark</th>
                                                <th>Date Added</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:delete_remark')): ?>
                                                    <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($remarks as $remark):
                                                ?>
                                                <tr>
                                                    <td><?= $remark->subject; ?></td>
                                                    <td><?= $remark->remark ?></td>
                                                    <td>
                                                        <?= date('d-M-Y', strtotime($remark->date_added)); ?>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:delete_remark')): ?>
                                                        <td>
                                                            <a class="delete" href="<?= site_url('setup/delete_remark/' . $remark->remark_id) ?>"> <i class="icons icon-trash"></i> Delete</a>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No remark found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_remark.php'; ?>
    <div class="modal hide fade" id="modal_edit_remark" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>

<script>
$(function () {
    $('body').delegate('.delete', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete this remark ?';
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