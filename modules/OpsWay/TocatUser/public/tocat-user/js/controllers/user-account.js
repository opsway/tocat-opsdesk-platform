var app = angular.module('tocatApp', ['xeditable']);

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});

app.controller('UserAccountCtrl', ['$scope', '$http', '$q', '$interval', function ($scope, $http, $q, $interval) {

    $scope.user = {};


    $scope.getAllGroups = function() {
        $http.get(URL_SHOW_USER)
            .success(function (data) {
                $scope.user = data
            });
    };

    $scope.getAllGroups();

}]).filter('mapYesNo', function () {
    return function (input) {
        return (input)?'Yes':'No';
    };
});