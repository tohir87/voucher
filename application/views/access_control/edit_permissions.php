<?= show_notification(); ?>
<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/access_control') ?>"> <i class="icons icon-chevron-left"></i>
            Back
        </a>
        <h1><?= ucfirst($staff->first_name) . ' ' . ucfirst($staff->last_name) ?></h1>
    </div>
</div>
<div class="breadcrumbs">
    <ul>
        <li><a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a><i class="icon-angle-right"></i></li>
        <li><a href="<?= site_url('/access_control') ?>">Access Control</a><i class="icon-angle-right"></i></li>
        <li><a href="#">Edit Permissions</a></li>
    </ul>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered box-color">
            <div class="box-title">
                <h3>Regular Permissions</h3>
            </div>
            <div class="box-content-padless">
                <form class="form-horizontal">
                    <?php
                    if (!empty($modules)):
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Modules</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($modules as $module): ?>
                                <tr>
                                    <td><?= $module->subject ?></td>
                                    <td>
                                        <?php
                                        foreach ($all_perms as $perm1):
                                        if ($perm1->module_id == $module->module_id):
                                        ?>
                                        <label class="checkbox"><input class="perms" type="checkbox" name="p[]" <?php
                                    if (!in_array($perm1->perm_id, $unassigned_perms)): echo 'checked';
                                    endif;
                                        ?> data-id="<?= $staff->user_id . '/' . $perm1->perm_id . '/' . $perm1->module_id; ?>" /> <?= $perm1->subject ?> </label>
                                            <?php
                                            endif;
                                            endforeach;
                                            ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                   endif ;
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="message_box" style="display: none;">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
        <h4 id="myModalLabel">Access Control</h4>
    </div>
    <div class="modal-body">
        <p id="msg"></p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-primary" id="submit_dialog_ok">Ok</button>
    </div>
</div>

<script>
    var id;
    var url = "<?php echo site_url('access_control/edit_user_permission'); ?>";
    var action;

    $('.perms').on('change', function (e) {
        e.preventDefault();
        id = $(this).data('id');

        if ($(this).is(':checked')) {
            action = 'insert';
        } else {
            action = 'delete';
        }

        $.ajax({
            type: 'post',
            url: url,
            data: {action: action, data: id},
            dataType: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                $('#msg').html(result);
                $('#message_box').modal('show');
            }
        });
        e.unbind();
    });

    $('#submit_dialog_ok').click(function () {
        $('#message_box').modal('hide');
    });
</script>