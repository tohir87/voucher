<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Manage Subscribers</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="box">
    <div class="box-content nopadding">
        <?php include '_sub_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Subscribers
                                </h3>
                                <a href="#new_user" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> Add Subscription
                                </a>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($subscribers)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <!--<th>Subscription Plan</th>-->
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sn = 0;
                                            foreach ($subscribers as $subscriber):
                                                ?>
                                                <tr>
                                                    <td><?= ++$sn; ?></td>
                                                    <td><?= ucfirst($subscriber->first_name . ' ' . $subscriber->last_name) ?></td>
                                                    <td><?= $subscriber->email ?></td>
                                                    <!--<td><?= $subscriber->plan ?></td>-->
                                                    <td>
                                                        <span class="label label-<?= $subscriber->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$subscriber->status] ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                            <ul class="dropdown-menu">
<!--                                                                <li>
                                                                    <a href="<?= site_url('/subscription/edit_subscriber/' . $subscriber->subscriber_id) ?>" class="edit_u">Edit</a>
                                                                </li>-->
                                                                <li>
                                                                    <a class="Toggle" data-status_id="<?= $subscriber->status?>" href="<?= site_url('subscription/changeStatus?id=' . $subscriber->subscriber_id . '&status=' . $subscriber->status) ?>"><?= $subscriber->status ? 'Disable' : 'Enable'; ?></a>
                                                                </li>
                                                                <li>
                                                                    <a class="deleteSub" href="<?= site_url('subscription/deleteSubscriber/' . $subscriber->subscriber_id) ?>">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No subscriber found.');
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
        $('body').delegate('.Toggle', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var id_ = $(this).data('status_id');
            var message = parseInt(id_) > 0 ? 'Are you sure you want to disable this subscriber?' : 'Are you sure you want to enable this subscriber';
            CTM.doConfirm({
                title: 'Status Change',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
    $(function () {
        $('body').delegate('.deleteSub', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this subscriber?';
            CTM.doConfirm({
                title: 'Confirm',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
</script>

