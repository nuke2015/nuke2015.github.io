app.controller("myTodoCtrl", function($scope) {
    $scope.message = "";
    $scope.left = function() {
        return 100 - $scope.message.length;
    };
    $scope.clear = function() {
        $scope.message="";
    };
    $scope.save = function() {
        $scope.message="";
        alert("Save OK!");
    };
});