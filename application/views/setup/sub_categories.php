<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Setup</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="box">
    <div class="box-content nopadding">
        <?php include '_setup_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Sub Categories
                                </h3>
                                <a href="#new_sub_category" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 10px">
                                    <i class="icons icon-plus-sign"></i> New Sub Category
                                </a>
                            </div>
                            <div class="box-content-padless">
                                <?php if (!empty($sub_categories)): ?>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sn = 0;
                                            foreach ($sub_categories as $sub):
                                                ?>
                                                <tr>
                                                    <td><?= ++$sn; ?></td>
                                                    <td><?= $category->category_name; ?></td>
                                                    <td><?= $category->category_desc ?></td>
                                                    <td>
                                                        <span class="label label-<?= $category->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$category->status] ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a class="Toggle" data-enabled='<?= $category->status ?>' href="<?= site_url('setup/changeCategoryStatus/' . $category->category_id ) ?>"><?= $category->status ? 'Disable' : 'Enable'; ?></a>
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

</div>

<div class="modal hide fade modal-full" id="new_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ng-app="categories" ng-controller="categCtrl" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Category</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div ng-repeat="status in data.categories" style="margin-bottom: 10px; border: 2px solid #006dcc;">
                <div class="control-group" style="margin-left: 30px">
                    <label for="group_id" class="control-label">Group</label>
                    <div class="controls">
                        <select required name="group_id[]" id="group_id">
                            <option value="" selected>Select Group</option>
                            <?php
                            if (!empty($groups)):
                                foreach ($groups as $group):
                                    ?>
                                    <option value="<?= $group->group_id; ?>"><?= $group->group_name; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="category_name" class="control-label">Category Name</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input' id="category_name" name="category_name[]">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="category_desc" class="control-label">Description</label>
                    <div class="controls">
                        <input type="text" placeholder="" class='input' id="category_desc" name="category_desc[]">
                        <a href="#" title="Remove this category" onclick="return false;" ng-click="removeItem($index)">
                            <i class="fa fa-fw fa-trash-o"></i> remove
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <a title="Click here to add" class="btn btn-warning pull-right" onclick="return false;" ng-click="addItem()">
                <i class="icons icon-plus"></i>
                Add more
            </a>
            <button data-dismiss="modal" class="btn btn-default" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
    </form>
</div>


<script>
    $(function () {
        $('.Toggle').click(function (e) {
            e.preventDefault();
            var h = this.href;
            var message = parseInt($(this).data('enabled')) ? 'If you disable this category, you \'ll no longer be able to assign products to it, Are you sure you want to continue? ' : 'Are you sure you want to enable this category ?';
            CTM.doConfirm({
                title: 'Confirm Status Change',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });


    var classApp = angular.module('categories', []);

    classApp.controller('categCtrl', function ($scope) {

        $scope.data = {categories: []};

        $scope.blankResult = {};

        $scope.addItem = function () {
            $scope.data.categories.push(angular.copy($scope.blankResult));
        };



        $scope.removeItem = function (idx) {
            if ($scope.data.categories.length > 0) {
                $scope.data.categories.splice(idx, 1);
            }
            $scope.check();
        };

        $scope.check = function () {
            if ($scope.data.categories.length == 0) {
                $scope.addItem();
            }
        };

        $scope.check();



    });
</script>