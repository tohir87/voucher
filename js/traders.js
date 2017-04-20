var traderApp = angular.module('trader', ['app.Ctm']);

var getSiteUrl = function () {
    return window.location.protocol + '//' + window.location.host + '/';
};

traderApp.controller('traderCtrl', function ($scope, $http) {
    $scope.market_id = market_id_;
    $scope.selected_products = selected_products_;
    $scope.product_id = '0';
    $scope.productStatus = 'Select market first';

    $scope.loadMarketProducts = function () {
        if (!$scope.market_id) {
            return;
        }
        var url = 'admin/get_market_products/' + $scope.market_id ;
        $scope.productStatus = 'Loading market products...';
        $http.get(getSiteUrl() + url)
                .success(function (data) {
                    $scope.productStatus = '';
                    $scope.products = data;
                })
                .error(function () {
                    $scope.productStatus = 'No product found';
                });
    };
    
    
    $scope.form_submit = function(){
        $("#frm").submit();
    };
    
    if (parseInt($scope.market_id) > 0){
        $scope.loadMarketProducts();
    }

});

//$('#phone').mask("(9999) - (999) - (9999)");
