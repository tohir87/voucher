/* global angular */

var reportApp = angular.module('report', ['app.Ctm', 'cgBusy', 'datatables', 'datatables.tabletools', 'datatables.scroller', 'datatables.fixedcolumns']);

reportApp.controller('ListCtrl', function ($scope, $http, SiteUrl, DTOptionsBuilder, DTColumnDefBuilder) {
    $scope.products = [];
    $scope.varieties = [];
    $scope.wholesale_metrics = [];
    $scope.retail_metrics = [];
    $scope.showContainer = false;

    $scope.data = {market: '', source: 0, source_err: '', product: '', variety: 0, metric_wholesale_id: 0, metric_retail_id: 0, startDate: '', endDate: ''};
    $scope.statuses = {0: 'Inactive', 1: 'Active', 2: 'Suspended', 3: 'Terminated', 4: 'Probation/Access', 5: 'No Access'};


    $scope.loadAllProducts = function () {
        $scope.employeesPromise = $http.get(SiteUrl.get('report/product_report_json'))
                .success(function (data) {
                    $scope.products = data;
                });
    };

    $scope.formatDate = function (date) {
        var dateOut = new Date(date);
        return dateOut;
    };

    $scope.loadVariety = function () {
        $scope.employeesPromise = $http.get(SiteUrl.get('report/product_variety_json/' + $scope.data.product))
                .success(function (data) {
                    $scope.varieties = data;
                });

        $scope.loadProductMetric();
        $scope.loadProductRetailMetric();
    };

    $scope.loadProductMetric = function () {
        $scope.employeesPromise = $http.get(SiteUrl.get('report/product_wholesale_metric_json/' + $scope.data.product))
                .success(function (data_) {
                    $scope.wholesale_metrics = data_;
                });
    };

    $scope.loadProductRetailMetric = function () {
        $scope.employeesPromise = $http.get(SiteUrl.get('report/product_retail_metric_json/' + $scope.data.product))
                .success(function (data_) {
                    $scope.retail_metrics = data_;
                });
    };

    $scope.filterResult = function () {
        if (!$scope.data.market) {
            alert("Please select a market");
            return false;
        }
        if (!$scope.data.product) {
            alert("Please select a product");
            return false;
        }
        $scope.employeesPromise = $http.get(SiteUrl.get('report/product_report_json' + '/' + $scope.data.market + '/' + $scope.data.product + '/' + $scope.data.variety + '/' + $scope.data.startDate + '/' + $scope.data.endDate))
                .success(function (data) {
                    $scope.products = data;
                });
    };

    $scope.analyseResult = function () {

        if (!$scope.data.product) {
            alert("Please select a product");
            return false;
        }

        $scope.employeesPromise = $http.get(SiteUrl.get('analytics/json_analyse_report' + '/' + $scope.data.market + '/' + $scope.data.product + '/' + $scope.data.variety + '/' + $scope.data.metric_wholesale_id + '/' + $scope.data.startDate + '/' + $scope.data.endDate))
                .success(function (data) {
                    $scope.displayChart(data, 'column', 'Wholesale');
                    $scope.displayLineChart(data, '', 'Wholesale');
                    $scope.displayAllLineChart(data, '', 'Wholesale');
                    $scope.displayPie(data, '', 'Wholesale');
                });
    };

    $scope.analyseRetail = function () {

        if (!$scope.data.product) {
            alert("Please select a product");
            return false;
        }

        $scope.employeesPromise = $http.get(SiteUrl.get('analytics/json_analyse_retail_report' + '/' + $scope.data.market + '/' + $scope.data.product + '/' + $scope.data.variety + '/' + $scope.data.metric_retail_id + '/' + $scope.data.startDate + '/' + $scope.data.endDate))
                .success(function (data) {
                    $scope.displayChart(data, 'column', 'Retail');
                    $scope.displayLineChart(data, '', 'Retail');
                    $scope.displayAllLineChart(data, '', 'Retail');
                    $scope.displayPie(data, '', 'Retail');
                });
    };

    $scope.getSourceProducts = function () {

        if ($scope.data.source == '0') {
            $scope.data.source_err = 'Please select a source';
            return false;
        } else {
            $scope.data.source_err = '';
        }

        $scope.productPromise = $http.get(SiteUrl.get('analytics/json_analyse_source_products' + '/' + $scope.data.source))
                .success(function (data) {
                    $scope.showContainer = true;
                    $scope.displayPie2(data.pie_data, 'pieContainer');
                    $scope.displayPie2(data.cumm_data.oyingbo, 'pieContainer_1');
                    $scope.displayPie2(data.cumm_data.mile12, 'pieContainer_2');
                    $scope.displayPie2(data.cumm_data.ketu, 'pieContainer_3');
                    $scope.displayPie2(data.cumm_data.iddo, 'pieContainer_4');
                });
    };

    $scope.displayChart = function (data, type, sub_title) {
        $('#container').highcharts({
            chart: {
                type: type
            },
            title: {
                text: 'Daily Average Prices'
            },
            subtitle: {
                text: sub_title
            },
            xAxis: {
                categories: data.categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Price (NGN)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} NGN</b></td></tr>'
                        + '<tr><td style="color:{series.color};padding:0">Reason for price change: </td>' +
                        '<td style="padding:0"><b>{point.options.note.text}</b></td></tr>'
                        + '<tr><td style="color:{series.color};padding:0">Activity: </td>' +
                        '<td style="padding:0"><b>{point.options.activity.text}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                cursor: 'pointer',
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: data.series
        });
    };

    $scope.displayLineChart = function (data, type, sub_title) {
        $('#lineContainer').highcharts({
            chart: {
                type: type
            },
            title: {
                text: ''
            },
            subtitle: {
                text: sub_title
            },
            xAxis: {
                categories: data.categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Price (NGN)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} NGN</b></td></tr>'
                        + '<tr><td style="color:{series.color};padding:0; max-width:400px">Reason for price change: </td>' +
                        '<td style="padding:0"><b>{point.options.note.text}</b></td></tr>'
                        + '<tr><td style="color:{series.color};padding:0;">Activity: </td>' +
                        '<td style="padding:0; max-width:400px"><b>{point.options.activity.text}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                cursor: 'pointer',
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: data.series
        });
    };

    $scope.displayAllLineChart = function (data, type, sub_title) {
        $('#AllMarketContainer').highcharts({
            chart: {
                type: type
            },
            title: {
                text: ''
            },
            subtitle: {
                text: sub_title
            },
            xAxis: {
                categories: data.categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Price (NGN)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} NGN</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                cursor: 'pointer',
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: data.allMarkets
        });
    };

    $scope.displayPie = function (data, id) {
        $('#pieContainer').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    name: "Quantity",
                    colorByPoint: true,
                    data: data.pie_data
                }]
        });
    };
    
    $scope.displayPie2 = function (data, id) {
        $('#'+id).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                    name: "Quantity",
                    colorByPoint: true,
                    data: data
                }]
        });
    };


    $scope.downloadResult = function () {
        if ($scope.data.product == '0' || $scope.data.product == '') {
            $("#select_product").modal();
            return false;
        }
        self.location = SiteUrl.get('report/report_download') + '/' + $scope.data.market + '/' + $scope.data.product + '/' + $scope.data.variety + '/' + $scope.data.startDate + '/' + $scope.data.endDate;

    };

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
    ;

    $scope.dtColumnDefs = [DTColumnDefBuilder.newColumnDef(0).notSortable(), DTColumnDefBuilder.newColumnDef(1).notSortable()];
});
