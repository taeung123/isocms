var myapp = angular.module('myapp', ['ui.bootstrap','angular-loading-bar', 'ngAnimate']);
myapp.controller("TravelController",function($scope, $location, $http, cfpLoadingBar, $filter,$sce){
    $scope.itemsContent = [];
    $scope.listContentSelected = [];
    $scope.urlLoadContent = '';
    $scope.search = $location.search();
    $scope.orderByTo = $scope.search.order;
    $scope.page = {totalItems: 0, currentPage: $scope.search.page, maxSize: 5};
    $scope.loadContent = function(url) {
        $scope.urlLoadContent = url;
    }
	
	$scope.renderHtml = function (htmlCode) {
           return $sce.trustAsHtml(htmlCode);
    };


    $scope.loadContentSelected = function(url) {
        $http.get(url).success(function(data) {
            $scope.listContentSelected = data.items;
        });
    }

    $scope.querySearch = function(){       
        angular.forEach($scope.search, function(value, key) {
            if (value == '' || value == 0)
                delete $scope.search[key];
        });
        $location.search($scope.search);
        var url = $scope.urlLoadContent + $location.url();
        $http.get(url).success(function(data) {
            $scope.itemsContent = data.items;
            $scope.page.totalItems = data.totalItems;
        });
    };
	
	$scope.deleteItem = function(Obj,url) {
		if (confirm('Are sure delete')) {
			console.log(Obj);						
			delete $scope.itemsContent[Obj.id];			
			$http.post(url, Obj).success(function(data, status) {
           		$scope.querySearch();
        	})
		}
    };
	
    $scope.setPage = function(pageNo) {
        $scope.page.currentPage = pageNo;
    };

    $scope.$watch('page.currentPage', function(o, n) {
        $scope.search.page = o;
        $scope.querySearch();
    });
});