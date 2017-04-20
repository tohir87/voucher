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
                                    User Types
                                </h3>
                            </div>
                            <div class="box-content-padless">
                                <?php if(!empty($user_types)): ?>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn = 0; foreach ($user_types as $user_type): ?>
                                        <tr>
                                            <td><?= ++$sn; ?></td>
                                            <td><?= ucfirst($user_type->user_type) ?></td>
                                            <td><a href="#">edit</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php else:
                                    echo show_no_data('No user type found');
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
