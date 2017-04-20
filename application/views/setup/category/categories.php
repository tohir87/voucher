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


<div class="box" ng-app="categories" ng-controller="categCtrl">
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
                                    Categories
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_category')): ?>
                                <a href="#new_category" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> New Category
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($categories)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Sub Categories</th>
                                                <th>Status</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_category')): ?>
                                                    <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($categories as $category):
                                                ?>
                                                <tr>
                                                    <td><?= $category->category_name; ?></td>
                                                    <td><?= $category->category_desc ?></td>
                                                    <td>
                                                        <span class="badge badge-success">
                                                            <?= $category->sub_categories ?>
                                                        </span> 
                                                        <a href="#view_sub_category" data-toggle='modal' ng-click="showSubCategory('<?= $category->category_id; ?>')" title="Click here to view sub categories">
                                                            view
                                                        </a>
                                                        <?php if ($this->user_auth_lib->have_perm('setup:edit_category')): ?>
                                                        | <a href="#new_sub_category" data-toggle="modal" ng-click="showSubCategory('<?= $category->category_id; ?>')" title="Click here to add new sub category"> 
                                                            <i class="icons icon-plus-sign"></i> add
                                                        </a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="label label-<?= $category->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$category->status] ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:edit_category')): ?>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="edit_category" href="<?= site_url('/setup/edit_category/' . $category->category_id) ?>">Edit</a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="Toggle" data-enabled='<?= $category->status ?>' href="<?= site_url('setup/changeCategoryStatus/' . $category->category_id . '/' . $category->status) ?>"><?= $category->status ? 'Disable' : 'Enable'; ?></a>
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
                                    echo show_no_data('No category found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_category.php'; ?>

    <?php include '_view_sub_categories.php'; ?>

    <div class="modal hide fade" id="modal_edit_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>
<script src="/js/category.js" type="text/javascript"></script>