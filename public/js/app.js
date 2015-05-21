var app = angular.module("app", ['ngRoute']).config(function($routeProvider) {
	$routeProvider.when('/login', {
		templateUrl: 'admin/user/login.html',
		controller: 'LoginController'
	});

	$routeProvider.when('/home', {
		templateUrl: 'admin/user/home.html',
		controller: 'HomeController'
	});

	// $routeProvider.otherwise({ redirectTo: '/home' });
});

app.controller('LoginController', function($scope, $location, $http) {
	window.scope = $scope;
	$scope.credentials = { username: "", password: ""};

	$scope.login = function() {
		console.log($scope.credentials.username);
		return $http.post("admin/login",$scope.credentials);
	};
	
});

app.controller('HomeController', function($scope, $location) {
	window.scope = $scope;
	$scope.title = "Pulasthi";
	$scope.message = "Mouse Over";

	$scope.logout = function() {
		$location.path('/login');
	}

	app.directive('showsMessageWhenHovered', function() {
		return {
			restrict: "A", // A = Attribute, C = Class Name, E= Element, M = HTML Comment
			link: function(scope, element, attributes) {
				var originalMessage = scope.message;
				element.bind("mouseover", function() {
					scope.message = attributes.message;
					scope.$apply();
				});
				element.bind("mouseout", function() {
					scope.message = originalMessage;
					scope.$apply();
				});
			}
		};
	});
});