var app = angular.module('tocatApp', ['ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.selection']);

app.controller('AdminGroupCtrl', ['$scope', '$http', '$q', '$interval', function ($scope, $http, $q, $interval) {

    $scope.groupsSelected = {};
    $scope.gridOptions = {};
    //$scope.gridOptions.enableFiltering = true;
    $scope.gridOptions.enableRowSelection = true;
    $scope.gridOptions.multiSelect = true;
    $scope.gridOptions.rowIdentity = function (row) {
        return row.id;
    };
    $scope.gridOptions.getRowIdentity = function (row) {
        return row.id;
    };

    $scope.gridOptions.enableGridMenu = true;
    $scope.gridOptions.gridMenuCustomItems = [
        {
            title: 'Save Selected Groups',
            action: function ($event) {
                $scope.selectSendToServer(URL_SAVE_GROUP_LIST);
            }
        },
        {
            title: 'Add Group',
            action: function ($event) {
                $scope.gridOptions.data.push({name:'Name',team: false, active:false});
            }
        },
        {
            title: 'Delete Selected Groups',
            action: function ($event) {
                if (confirm('Are you sure?')) $scope.selectSendToServer(URL_DELETE_GROUP);
            }
        },
        {
            title: 'Assign members',
            action: function ($event) {
                alert('modalWindow?');
            }
        }
    ];

    $scope.gridOptions.columnDefs = [
        {name: 'id', enableCellEdit: false},
        {name: 'name', displayName: 'Name'},
        {name: 'description'},
        {name: 'team', displayName: 'Is Team', type: 'boolean', cellFilter: 'mapYesNo'},
        {name: 'active', displayName: 'Active', type: 'boolean', cellFilter: 'mapYesNo'}
    ];

    $scope.saveRow = function (rowEntity) {
        // create a fake promise - normally you'd use the promise returned by $http or $resource
       //var promise = $q.defer();
        //$scope.gridApi.rowEdit.setSavePromise($scope.gridApi.grid, rowEntity, promise.promise);
        // fake a delay of 3 seconds whilst the save occurs, return error if gender is "male"
        $http.post(URL_SAVE_GROUP, rowEntity)
            .success(function (data) {
                if (data['id'] != undefined) {
                    $scope.getAllGroups();
                }
            }).error(function (data) {
                alert("AJAX failed to Load Data");
            });


    };

    $scope.selectSendToServer = function(url) {
        var rows = $.extend(true,[],$scope.gridApi.selection.getSelectedRows());
        if (rows.length == 0) {
            alert('Please select row!');
            return;
        }
        rows.forEach(function(row){
            if (row.users !== undefined) delete row['users'];
        });
        $http.post(url, rows)
            .success(function (data) {
                $scope.gridApi.selection.getSelectedGridRows().forEach(function (row) {
                    row.isSelected = false;
                });
                $scope.getAllGroups();
                $scope.groupsSelected = {};
            }).error(function (data) {
                alert("AJAX failed to Load Data");
            });
    };

    $scope.gridOptions.onRegisterApi = function (gridApi) {
        //set gridApi on scope
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
            $scope.gridApi.selection.selectRow(rowEntity);
            $scope.$apply();
        });
        //gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
        gridApi.selection.on.rowSelectionChanged($scope, function (row) {
            if (row.entity.id  === undefined) return;
            if (row.isSelected) {
                $scope.groupsSelected[row.entity.id] = row.entity;
            } else {
                delete  $scope.groupsSelected[row.entity.id];
            }
            console.log(row);
            //$log.log(msg);
        });

    };

    $scope.getAllGroups = function() {
        $http.get(URL_SHOW_GROUP_LIST)
            .success(function (data) {
                $scope.gridOptions.data = data
            });
    };

    $scope.getAllGroups();
}]).filter('mapYesNo', function () {
    return function (input) {
        return (input)?'Yes':'No';
    };
});