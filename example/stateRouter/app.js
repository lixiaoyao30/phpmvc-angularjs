var app=angular.module("myapp",['ui.router']);//声明angualrjs模块，并把ui-router传人angularjs模块
app.config(function ($stateProvider, $urlRouterProvider) { //声明把$stateprovider和$urlrouterprovider路由引擎作为函数参数传人,为应用程序配置路由
     $urlRouterProvider.otherwise("/pagetable"); 
     $stateProvider    
        .state("pagetable", {
            url: "/pagetable",
            templateUrl: "pagetable.html"  //第一个显示出来的页面
        })
        .state("pagetable.page1", {
            url:"/page1",
            templateUrl: "page1.html" //
        })
        .state("pagetable.page2", {
            url:"/page2",
            templateUrl: "page2.html"
        })
        .state("pagetable.page3", {
            url:"/page3",
            templateUrl: "page3.html"
        });
});