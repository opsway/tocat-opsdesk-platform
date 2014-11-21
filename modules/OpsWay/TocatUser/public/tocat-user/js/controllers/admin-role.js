
(function() {
  'use strict';
  var sampleData;

  angular.module('tocatApp', ['ui.tree'])
  .controller('adminRoleCtrl', function($scope, $http, $timeout) {

          var extractData = function () {
              var map = {}, node = [];
              $scope.rolesList = [];
              for (var i = 0; i < sampleData.length; i++) {
              //    if (sampleData[i].pid === undefined)
                  node = sampleData[i];
                  node.editing = false;
                  node.save = function(){
                      this.editing = false;
                  };
                  node.nodes = [];
                  map[node.id] = i; // use map to look-up the parents
                  if (node.parentId != "0") {
                      sampleData[map[node.parentId]].nodes.push(node);
                  } else {
                      $scope.rolesList.push(node);
                  }
                  delete node.parentId;
              }
          };

    $scope.deleteNode = function(node) {
        $scope.editedFlag = true;
        node.remove();
    };

    $scope.moveNode = function(node) {
      $scope.editedFlag = true;
      node.toggle();
    };

      $scope.editItem = function(node) {
          node.editing = true;
         };

         $scope.cancelEditingItem = function(node) {
             node.editing = false;
         };

         $scope.saveItem = function(node) {
             node.save();
             $scope.editedFlag = true;
         };

    $scope.newSubItem = function(scope) {
      var nodeData = scope.$modelValue;
        //$scope.editedFlag = true;
      nodeData.nodes.push({
        //id: nodeData.id * 10 + nodeData.nodes.length,
        roleId: nodeData.roleId + '_' + (nodeData.nodes.length + 1),
        nodes: [],
        save: function(){
                                    this.editing = false;
                                }
      });
        $scope.saveTree();
    };

          $scope.saveTree = function() {
              var dataSource = $http.post(URL_SAVE_ROLE_LIST, $scope.rolesList);
              if (dataSource) {
                  dataSource.success(function (data) {
                      sampleData = data;
                      // At first only populate the TreeView with root items
                      extractData();
                      //loadList();
                  });
                  dataSource.error(function (data) {
                      alert("AJAX failed to Load Data");
                  });
              }
              $scope.editedFlag = false;
          };

    $scope.rolesList = [];
          $scope.editedFlag = false;

        var loadList = function(){
              // Read data from a JSON file using $http methods
              var dataSource = $http.get(URL_SHOW_ROLE_LIST);
              if (dataSource) {
                  dataSource.success(function (data) {
                      sampleData = data;
                      // At first only populate the TreeView with root items
                      extractData();
                  });
                  dataSource.error(function (data) {
                      alert("AJAX failed to Load Data");
                  });
              }
        };
          var timer = $timeout(function () {
              loadList();
              $timeout.cancel(timer);
          }, 300);


  });

})();