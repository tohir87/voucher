$(function () {
    $('body').delegate('.ToggleProduct', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = parseInt($(this).data('enabled')) ? 'Are you sure you want to disable this product? ' : 'Are you sure you want to enable this product ?';
        CTM.doConfirm({
            title: 'Confirm Status Change',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});
$(function () {
    $('body').delegate('.deleteProduct', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete this product ?';
        CTM.doConfirm({
            title: 'Confirm Delete',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});


var productApp = angular.module('products', ['app.Ctm', 'cgBusy', 'datatables', 'datatables.tabletools', 'datatables.scroller', 'datatables.fixedcolumns']);

productApp.controller('productCtrl', function ($scope, $http, SiteUrl, DTOptionsBuilder, DTColumnDefBuilder) {

    var getSiteUrl = function () {
        return window.location.protocol + '//' + window.location.host + '/';
    };

    $scope.product = {category_id: category_id_, sub_category_id : sub_category_id_, sub_categories: []};
    $scope.products = [];
    $scope.subCatStatus = "Select category first";
    $scope.config = window.productConfig || {};

    $scope.loadSubCategories = function () {
        if (!$scope.product.category_id){
            return false;
        }
        $scope.product.sub_categories = [];
        $scope.myPromise = $http.get(getSiteUrl() + "setup/json_get_sub_categories/" + $scope.product.category_id)
                .success(function (response) {
                    $scope.subCatStatus = "";
                    $scope.product.sub_categories = response;
                });

        $("#sub_category_id").select2();

    };

    $scope.productPromise = $http.get(getSiteUrl() + "setup/json_get_products")
            .success(function (data) {
                $scope.products = data.aaData;
            });

    $scope.addSource = function (product_id) {
        $("#source_product_id").val(product_id);
        $("#add_source").modal();
    };

    $scope.addVariety = function (product_id) {
        $("#variety_product_id").val(product_id);
        $("#add_variety").modal();
    };
    
    $scope.addMetric = function(product_id){
        $("#metric_product_id").val(product_id);
        $("#add_metric").modal();
    };

    $scope.trimName = function (p) {
        return p.replace('/[^A-Z0-9]+/i()', '-');
    };
    
    if (parseInt($scope.product.category_id) > 0){
        $scope.loadSubCategories();
    }

    $scope.dtOptions = DTOptionsBuilder.newOptions()
            .withPaginationType('full_numbers')
            .withDisplayLength(100)
            .withOption('bFilter', true)
            .withTableTools(SiteUrl.get('/js/plugins/datatable/swf/copy_csv_xls_pdf.swf'))
            .withTableToolsButtons([
                'copy',
                'print', {
                    'sExtends': 'collection',
                    'sButtonText': 'Save',
                    'aButtons': ['csv', 'xls', 'pdf']
                }
            ])
            ;
    //.withBootstrap();
    ;

    $scope.dtColumnDefs = [DTColumnDefBuilder.newColumnDef(0).notSortable(), DTColumnDefBuilder.newColumnDef(1).notSortable()];

});