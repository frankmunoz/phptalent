/**
 * Movie Service
 * @namespace MovieService
 * @memberOf Service
 */
(function () {
    'use strict';

    angular
            .module('app.movie')
            .factory('MovieService', MovieService);

    MovieService.$inject = ['$http'];

    /**
     * @namespace MovieService
     * @param $http
     * @memberOf movie
     */
    function MovieService($http) {
        var urlService = 'api/';

        var service = {
            get: __get,
            retrieve: __retrieve,
            filter: __filter
        };

        return service;

        function __get() {
            var url = urlService + "movies";
            return $http({
                url: url,
                method: 'GET'
            })
                    .then(getComplete)
                    .catch(getFailed);
        }

        function __retrieve() {
            var url = urlService + "movies/retrieve";
            return $http({
                url: url,
                method: 'GET'
            })
                    .then(getComplete)
                    .catch(getFailed);
        }

        function __filter(params) {
            return $http.post(urlService + 'movies/filter', params)
                    .then(getComplete)
                    .catch(getFailed);
        }

        function getComplete(response) {
            return response.data;
        }

        function getFailed(error) {
            return {
                error: true,
                message: error
            };
        }


    }
})();