"use strict";
/**
 * app Router
 * This class manages all the paths to the frontend
 * @namespace app.router
 * @memberOf router
 */
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
                .when('/logout', {
                    title: 'Autenticación',
                    templateUrl: 'app/Authentication/index-authentication.html',
                    controller: 'AuthenticationCtrl',
                    controllerAs: 'authentication'
                })
                .otherwise({
                    redirectTo: '/'
                });
    }
})();

