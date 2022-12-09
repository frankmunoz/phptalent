"use strict";

(function () {
    angular
            .module('app')
            .config(config);

    function config($routeProvider){
        $routeProvider
                .when('/', {
                    title: 'Autenticación',
                    templateUrl: 'app/Authentication/index-authentication.html',
                    controller: 'AuthenticationCtrl',
                    controllerAs: 'authentication'
                })
               .when('/movies', {
                    title: 'Movies',
                    templateUrl: 'app/Movie/index-movie.html',
                    controller: 'MovieCtrl',
                    controllerAs: 'movies'
                })
                .otherwise({
                    redirectTo: '/'
                });
    }
})();

