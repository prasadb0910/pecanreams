"use strict";
const app = angular.module('Login',[]);
/*---------------------------------------------------------------------------------
    Making service to run ajax
---------------------------------------------------------------------------------*/
app.service('runAjax', ['$http', function ($http) {
    

    this.ajaxFunction = function(request,callback){
        const url=request.url;
        const data=request.data;

        $http.post(url,data).success(function(data, status, headers, config) {
            callback(data);
        })
        .error(function(err){
            callback(err);
        });
    }
}]);

app.controller('LoginController', function ($scope,$window,runAjax) {

   /*---------------------------------------------------------------------------------
    Call to Login
    ---------------------------------------------------------------------------------*/
   $scope.login = function() {
        if (typeof $scope.email  == "undefined"  || $scope.email  == "" ) {

            alert(`Enter Login Email`);

        }else if(typeof $scope.password == "undefined"  || $scope.password  == "" ){ 

            alert(`Enter Login Password`);

        }else{
            var data={
                url: BASE_URL+'login2',
                data:{
                    email:$scope.email,
                    password:$scope.password,
                    _token : $scope._token
                }
            }

            runAjax.ajaxFunction(data,function(result){
                
                if(result.loggedIn == true){
                    mixpanel.identify($scope.email);
                    mixpanel.people.set({
                        "$email": $scope.email,            // only special properties need the $
                        "$last_login": new Date(),         // properties can be dates...
                        "status": "Successful"             // feel free to define your own properties
                    });

                    var link = result.link;
                    $window.location.href = BASE_URL+link;
                }else{
                    alert(result.error);
                }
            });

        }
    };
});