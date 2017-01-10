var app=angular.module("myapp",['ui.router']);
app.config(function($stateProvider,$urlRouterProvider){
	$urlRouterProvider.otherwise("/home");
	$stateProvider
	    .state("home",{
	    	url:"/home",
	    	//templateUrl:"home.html"
	    	views: {
	    		"main" : {
	    			templateUrl: "home.html"
	    		},
	    		
              
	    		}
	    })
	     .state("home.list",{
	    	    url:"/list",
	    	    views:{
	    	    	"":{
	    	    		templateUrl:"home-list.html",
	    	    	    controller: function($scope) {
			                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
			            },
	    	    	} 
	    	    }
	    	
	     })
	     .state("home.paragraph",{
	    	   url:"/paragraph",
	    	   views:{
	    		  "":{
	    			  template: 'I could sure use a drink right now.'
	    		  }
	    		   
	    	   }
	     })
	     .state("aboutN",{
	    	 url:"/about",
	    	 views:{
	    		"main" : {
		    			templateUrl: "about.html"
		    		},
		        "one@aboutN":{templateUrl:'about-one.html',controller:'oneController'},
		        "two@aboutN":{templateUrl:'about-two.html',controller:'oneController'}
	    	 }
	     })
	   
	
});

app.controller("oneController",function($scope){
	$scope.message = 'test';
    $scope.scotches = [
                       {
                           name: 'Macallan 12',
                           price: 50
                       },
                       {
                           name: 'Chivas Regal Royal Salute',
                           price: 10000
                       },
                       {
                           name: 'Glenfiddich 1937',
                           price: 20000
                       }
                   ];
	
});