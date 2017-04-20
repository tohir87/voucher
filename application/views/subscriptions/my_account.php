<?= show_notification();
?>

<?php
// get all selected market IDs
$idMarket = [];
if (!empty($my_markets)){
    foreach ($my_markets as $market) {
        array_push($idMarket, $market->market_id);
    }
}

// get all selected products
$idProducts = [];
if (!empty($my_products)){
    foreach ($my_products as $product) {
        array_push($idProducts, $product->product_id);
    }
}
?>

<script>
var product_count = '<?= $subscription ? $subscription->product_count - count($my_products) : 0; ?>';
</script>

<div class="page-header">
    <div class="pull-left">
        <h1>My Account</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>My Products</h3>
                <a class="btn btn-success pull-right" href="#addProducts" data-toggle="modal" style="margin-right: 5px;">Add products</a>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($my_products)): ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:30px;">SN</th>
                                <th>&nbsp;</th>
                                <th>Product</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($my_products as $aProduct):
                                ?>
                                <tr>
                                    <td><?= ++$i; ?></td>
                                    <td class="img" style="width: 40px;">
                                        <img src="<?= $aProduct->image_url ?>" alt="<?= $aProduct->product_name ?>" title="<?= $aProduct->product_name ?>">
                                    </td>
                                    <td><?= $aProduct->product_name ?></td>
                                    <td>
                                        <a title="Click here to remove product" class="rmProduct" href="<?= site_url('/subscriber/removeProduct/' . $aProduct->subscriber_product_id); ?>">
                                            <i class="icons icon-trash"></i> Remove
                                        </a>
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No Product has been added to your account. <a href=#addProducts data-toggle=modal>Click here to add products</a>');

                endif;
                ?>
            </div>
        </div>
    </div>
    
    <div class="span6">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>Markets</h3>
                <a class="btn btn-success pull-right" href="#addMarket" data-toggle="modal" style="margin-right: 5px;">Add Market</a>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($my_markets)): ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:30px;">SN</th>
                                <th>Market</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($my_markets as $aMarket):
                                ?>
                                <tr>
                                    <td><?= ++$i; ?></td>
                                    <td><?= $aMarket->market_name; ?></td>
                                    <td>
                                        <a title="Click here to remove market" class="rmMarket" href="<?= site_url('/subscriber/removeMarket/' . $aMarket->subscriber_market_id); ?>">
                                            <i class="icons icon-trash"></i> Remove
                                        </a>
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                else:
                    echo show_no_data('No Market has been added to your account. <a href=#addMarket data-toggle=modal>Click here to add market</a>');

                endif;
                ?>
            </div>
        </div>
    </div>
    <?php include '_add_product_modal.php'; ?>
    <?php include '_add_market_modal.php'; ?>
</div>



<script>
    $(function () {
        $('body').delegate('.rmProduct', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to remove this product?';
            CTM.doConfirm({
                title: 'Confirm',
                message: message,
                cancelText: 'No',
                acceptText: 'Yes',
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });
    $(function () {
        $('body').delegate('.rmMarket', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to remove this market?';
            CTM.doConfirm({
                title: 'Confirm',
                message: message,
                cancelText: 'No',
                acceptText: 'Yes',
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });

   
    var classApp = angular.module('subproducts', ['app.Ctm']);

    classApp.controller('productCtrl', function ($scope, $http) {
        
        $scope.data = {products: []};

        $scope.blankResult = {};

        $scope.addItem = function () {
            if ($scope.data.products.length < product_count){
                $scope.data.products.push(angular.copy($scope.blankResult));
            }else{
                alert('Sorry your subscription does not allow for more than ' + $scope.data.products.length + ' products.');
            }
        };

        $scope.removeItem = function (idx) {
            if ($scope.data.products.length > 0) {
                $scope.data.products.splice(idx, 1);
            }
            $scope.check();
        };

        $scope.check = function () {
            if ($scope.data.products.length == 0) {
                $scope.addItem();
            }
        };
        

        $scope.check();

    });
</script>