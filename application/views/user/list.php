<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>User Admin</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="box">
    <div class="box-content nopadding">
        <?php include '_user_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Users
                                </h3>
                                <a href="#new_user" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> Add User
                                </a>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($users)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>User Type</th>
                                                <th>Markets</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sn = 0;
                                            foreach ($users as $user):
                                                ?>
                                                <tr>
                                                    <td><?= ++$sn; ?></td>
                                                    <td><?= ucfirst($user->first_name . ' ' . $user->last_name) ?></td>
                                                    <td><?= $user->email ?></td>
                                                    <td><?= $user->user_type ?></td>
                                                    <td><?php 
                                                    $user_markets = $this->user_auth_lib->getUserMarkets($user->user_id);
                                                    if (!empty($user_markets)):
                                                        foreach($user_markets as $mkt): ?>
                                                        <span class="label label-default"><?= $mkt->market_name; ?></span>
                                                       <?php endforeach;
                                                    endif;
                                                    ?></td>
                                                    <td>
                                                        <span class="label label-<?= $user->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$user->status] ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($this->user_auth_lib->get('user_id') != $user->user_id): ?>
                                                            <div class="btn-group">
                                                                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="<?= site_url('/user/edit_user/' . $user->user_id) ?>" class="edit_u">Edit</a>
                                                                    </li>
                                                                    <?php if ($user->user_type !== 'Admin'): ?>
                                                                        <li>
                                                                            <a href="<?= site_url('/user/assign_market/' . $user->user_id) ?>" class="add_market">Assign Market</a>
                                                                        </li>
                                                                    <?php endif; ?>

                                                                    <li>
                                                                        <a class="Toggle" href="<?= site_url('admin/changeUserStatus/' . $user->user_id) ?>"><?= $user->status ? 'Disable' : 'Enable'; ?></a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="deleteUser" href="<?= site_url('user/deleteUser/' . $user->user_id) ?>">Delete</a>
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
                                    echo show_no_data('No user has been added');
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

<?php include '_new_user_modal.php'; ?>

<!-- Assign market modal -->
<div class="modal hide fade" id="modal_assign_market" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >

</div>

<div class="modal hide fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>


<script src="/js/users.js"></script>