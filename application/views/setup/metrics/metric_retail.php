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


<div class="box" ng-app="metrics" ng-controller="wholesaleCtrl">
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
                                    Retail Metrics
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_metric')): ?>
                                <a href="#new_r_metric" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> New Metric
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($r_metrics)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>Metric</th>
                                                <th>Description</th>
                                                <th>Categories</th>
                                                <th>Status</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_metric')): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($r_metrics as $metric):
                                                ?>
                                                <tr>
                                                    <td><?= $metric->metric; ?></td>
                                                    <td><?= $metric->description ?></td>
                                                    <td>
                                                        <span class="badge badge-success">
                                                            <?= $metric->sub_categories ?>
                                                        </span> 
                                                        <a href="#view_sub_category" data-toggle='modal' ng-click="showSubCategory('<?= $metric->metric_retail_id; ?>', 'metric_retail_category')">
                                                            view
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="label label-<?= $metric->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$metric->status] ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:edit_metric')): ?>
                                                    <td>
                                                        <a class="edit_metric" href="<?= site_url('/setup/edit_metric/'.$metric->metric_retail_id . '/2')?>"> <i class="icons icon-edit"></i> Edit</a> | 
                                                        <a class="Toggle" data-enabled='<?= $metric->status ?>' href="<?= site_url('setup/deleteRetailMetric/' . $metric->metric_retail_id) ?>" > <i class="icons icon-trash"></i> Delete </a> |
                                                        <a href="#new_r_metric_sub" data-toggle="modal" ng-click="addSubCategory('<?= $metric->metric_retail_id; ?>')"> Assign to Category</a>

                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No metric found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_r_metric.php'; ?>
     <div class="modal hide fade" id="modal_edit_metric" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>
<script src="/js/metric.js" type="text/javascript"></script>