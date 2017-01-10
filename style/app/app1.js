var app = angular.module('myApp', ['ngRoute']);
app.filter('searchFor', function(){
  
	// All filters must return a function. The first parameter
	// is the data that is to be filtered, and the second is an
	// argument that may be passed with a colon (searchFor:searchString)

	return function(arr, searchString){
         //  console.log(arr+'|'+searchString);
		if(!searchString){
			return arr;
		}
       
		var result = [];

		searchString = searchString.toLowerCase();

		// Using the forEach helper method to loop through the array
		angular.forEach(arr, function(item){
            
			if(item.customerName.toLowerCase().indexOf(searchString) !== -1){
				result.push(item);
			}

		});

		return result;
	};

});
app.factory("services", ['$http', function($http) {
  var serviceBase = 'http://localhost/angularjs/phpmvc/';
    var obj = {};
    obj.getCustomers = function(){
    	
        return $http.get(serviceBase+'?controller=posts&action=all#/');
    }
    obj.getCustomer = function(customerID){
        return $http.get(serviceBase+'?controller=posts&action=getCustomer&id='+customerID);
    
       
    }

    obj.insertCustomer = function (customer) {
    return $http.post(serviceBase+'?controller=posts&action=insertCustomer', customer).then(function (results) {
        return results;
    });
	};

	obj.updateCustomer = function (id,customer) {
	
	    return $http.post(serviceBase+'?controller=posts&action=updateCustomer', {id:id, customer:customer}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteCustomer = function (id) {
	    return $http.delete(serviceBase + '?controller=posts&action=deleteCustomer&id='+id).then(function (status) {
	        return status.data;
	    });
	};

    return obj;   
}]);

app.controller('listCtrl', function ($scope, services) {
    services.getCustomers().then(function(data){
    	//console.log(data);
        $scope.customers = data.data;
    });
});

app.controller('editCtrl', function ($scope, $rootScope, $location, $routeParams, services, customer) {
	
	var customerID = ($routeParams.customerID) ? parseInt($routeParams.customerID) : 0;

    $rootScope.title = (customerID > 0) ? 'Edit Customer' : 'Add Customer';
    $scope.buttonText = (customerID > 0) ? 'Update Customer' : 'Add New Customer';
      var original = customer.data;
       
      original._id = customerID;
      
      $scope.customer = angular.copy(original);
     
      $scope.customer._id = customerID;
      //console.log(angular.copy(original)+'|'+$scope.customer);
      $scope.isClean = function() {
    	 // console.log(angular.equals(original, $scope.customer));
        return angular.equals(original, $scope.customer);
      }

      $scope.deleteCustomer = function(customer) {
        $location.path('/');
        if(confirm("Are you sure to delete customer number: "+$scope.customer._id)==true)
        services.deleteCustomer(customer.customerNumber);
      };

      $scope.saveCustomer = function(customer) {
        $location.path('/');
        if (customerID <= 0) {
            services.insertCustomer(customer);
        }
        else {
        	
            services.updateCustomer(customerID, customer);
        }
    };
});

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        title: 'Customers',
        templateUrl: './views/partials/customers.html',
        controller: 'listCtrl'
      })
      .when('/edit-customer/:customerID', {
        title: 'Edit Customers',
        templateUrl: './views/partials/edit-customer.html',
        controller: 'editCtrl',
        resolve: {
          customer: function(services, $route){
            var customerID = $route.current.params.customerID;
          //  console.log(services.getCustomer(customerID));
     
         return services.getCustomer(customerID);
          }
        }
      })
      .otherwise({
        redirectTo: '/'
      });
}]);
app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);










