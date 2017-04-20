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


<div class="box" ng-app="varieties" ng-controller="varietyCtrl">
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
                                    Varieties
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_variety')): ?>
                                    <a href="#new_variety" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                        <i class="icons icon-plus-sign"></i> New Variety
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($varieties)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>Variety</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_variety')): ?>
                                                    <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($varieties as $variety):
                                                ?>
                                                <tr>
                                                    <td><?= $variety->variety; ?></td>
                                                    <td><?= $variety->description ?></td>
                                                    <td>
                                                        <span class="label label-<?= $variety->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$variety->status] ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:edit_variety')): ?>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="edit_variety" href="<?= site_url('/setup/edit_variety/' . $variety->variety_id) ?>">Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="Toggle" data-enabled='<?= $variety->status ?>' href="<?= site_url('setup/changeVarietyStatus/' . $variety->variety_id . '/' . $variety->status) ?>" > <?= $variety->status ? 'Disable' : 'Enable'; ?> </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No variety found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_variety.php'; ?>
    <div class="modal hide fade" id="modal_edit_variety" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>
<script src="/js/variety.js" type="text/javascript"></script>