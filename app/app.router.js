"use strict";

(function () {
    angular
            .module('app')
            .config(config);

    function config($routeProvider){
        $routeProvider
                .when('/', {
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

