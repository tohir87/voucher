<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">
        <h1>Access Control</h1>
    </div>
</div>
<div class="breadcrumbs">
    <ul>
        <li><a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a><i class="icon-angle-right"></i></li>
        <li><a href="#">Access Control</a><i class="icon-angle-right"></i></li>
    </ul>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Access Control
                </h3>
            </div>
            <div class="box-content nopadding">
                <?php
                if (!empty($staffs)) :
                    ?>

                    <table class="table table-hover table-nomargin table-striped dataTable dataTable-reorder">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th class='hidden-350'>Access Level</th>
                                <th>Email</th>
                                <th class='hidden-1024'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staffs as $s) : ?>
                                <tr>
                                    <td>
                                        <strong><?= ucfirst($s->first_name) . ' ' . ucfirst($s->last_name) ?></strong></td>
                                    <td class='hidden-350'>
                                        <?= $s->user_type_id == 1 ? 'Admin' : 'User';
                                        ?>
                                    </td>
                                    <td>
                                        <?= $s->email; ?>
                                    </td>
                                    <td class='hidden-1024'>
                                        <?php if ($this->user_auth_lib->get('user_id') != $s->user_id): ?>
                                        <div class="btn-group">
                                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="<?= site_url('access_control/edit_permissions/' . $s->user_id) ?>">Edit Permissions</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No staff found');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal message box -->
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

<!-- No access modal message box -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="no_access_box" style="display: none;">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
        <h4 id="myModalLabel">Access Control</h4>
    </div>
    <div class="modal-body">
        This employee does not have login access to the staff portal. To grant access, go to Staff Records -> Staff Directory, and change status to "Active" or "Probation/with Access".
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-primary" id="no_access_dialog_ok">Ok</button>
    </div>
</div>

<!-- Edit administrator access status modal message box -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="edit_admin_access_box" style="display: none;">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
        <h4 id="myModalLabel">Access Control</h4>
    </div>
    <div class="modal-body">
        Access denied. You cannot edit administrator's access level.
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-primary" id="no_access_dialog_ok">Ok</button>
    </div>
</div>

<script>
    var id_ref;
    var acct;
    var email;
    var url = "<?php echo site_url('access_control/access_control/assign_employee_default_access_status'); ?>";
    var type_admin = "<?php echo USER_TYPE_ADMIN ?>";
    var acct_type;

    $('.edit_permission_status').click(function () {
        id_ref = $(this).data('id_ref');
        email = $(this).data('email');
        acct_type = $(this).data('id_acct_type');

        // Check if user is administrator or HR admin
        if (type_admin == acct_type) {
            $('#edit_admin_access_box').modal('show');
        } else {
            $('#edit_permission_box').modal('show');
        }
    });

    $('#edit_access_btn').click(function (e) {
        e.preventDefault();
        acct = $('#acct').val();
        //$('form#frm_access').submit();
        //alert(url);

        $.ajax({
            type: 'post',
            url: url,
            data: {id_string: id_ref, acct_type: acct, email: email},
            dataType: 'html',
            beforeSend: function () {
                $('#edit_permission_box').modal('hide');
            },
            success: function (result) {
                //alert(result);
                $('#msg').html(result);
                $('#message_box').modal('show');
            }
        });
        e.unbind();
    });

    $('#submit_dialog_ok').click(function () {
        window.location.reload(true);
    });

    /* NO ACCESS DIALOG BOX */
    $('.no_access').click(function () {
        $('#no_access_box').modal('show');
    });

</script>