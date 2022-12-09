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
