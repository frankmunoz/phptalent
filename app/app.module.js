/**
 * app Module
 * This anonimous and autoexecutable function have the responsability to add each module of the system 
 * and link with the js module
 * @namespace app.router
 * @memberOf module
 */
(function () {
    'use strict';
    angular
            .module('app', [
                'app.authentication',
                'app.movie',
                'ngRoute'
            ])
            .run(['$location', '$rootScope', function ($location, $rootScope) {
                    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
                        $rootScope.title = current.$$route.title;
                    });
                }]);
})();
