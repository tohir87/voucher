var marketApp = angular.module('market', ['app.Ctm', 'cgBusy']);

marketApp.controller('priceCtrl', function ($scope, $http, SiteUrl) {

    $scope.data = {prices: []};
    $scope.apply_all = 0;
    $scope.disable_add_btn = false;

    var getSiteUrl = function () {
        return window.location.protocol + '//' + window.location.host + '/';
    };

    $scope.blankResult = {};

    $scope.addPrice = function () {
        $scope.data.prices.push(angular.copy($scope.blankResult));
    };
    
    $scope.addSource = function (product_id) {
        $("#source_product_id").val(product_id);
        $("#add_source").modal();
    };

    $scope.removePrice = function (idx) {
        if ($scope.data.prices.length > 0) {
            $scope.data.prices.splice(idx, 1);
        }
        $scope.check();
    };

    $scope.check = function () {
        if ($scope.data.prices.length == 0) {
            $scope.addPrice();
        }
    };
    
    $scope.disableAdd = function () {
        
        if ($('#apply_all').is(":checked")){
            $scope.disable_add_btn = true;
        }else{
            $scope.disable_add_btn = false;
        }
        
    };
    
    $scope.Ok = function(){
        var is_ok = true;
        if ($scope.data.prices.length > 0){
            for(i=0; i <= $scope.data.prices.length; ++i){
                if ( parseDouble($('#price_wholesale_low_' + i).val()) > parseDouble($('#price_wholesale_high_' + i).val()) ){
                    is_ok = false;
                }
            }
        }
        return is_ok;
    };
    
    
    $scope.check();

});