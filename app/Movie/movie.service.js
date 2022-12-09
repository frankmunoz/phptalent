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

        /**
         * Get
         *
         * This method is used to retieve all the Movies from the Json backend endpoint
         *
         * @param 
         * @return object with structure response
         */
        function __get() {
            var url = urlService + "movies";
            return $http({
                url: url,
                method: 'GET'
            })
                    .then(getComplete)
                    .catch(getFailed);
        }

        /**
         * Retrieve
         *
         * This method is used to retieve all the Movies from the URI backend endpoint 
         *
         * @param  
         * @return object with structure response
         */
        function __retrieve() {
            var url = urlService + "movies/retrieve";
            return $http({
                url: url,
                method: 'GET'
            })
                    .then(getComplete)
                    .catch(getFailed);
        }

        /**
         * Filter
         *
         * This method is used to filter the Movies from the backend endpoint depending of the criteria params
         *
         * @param object params
         * @return object with structure response
         */
        function __filter(params) {
            return $http.post(urlService + 'movies/filter', params)
                    .then(getComplete)
                    .catch(getFailed);
        }

        /**
         * GetComplete
         *
         * This method is used to get the response from the endpoint in succesfull case 
         *
         * @param object response
         * @return object with structure response
         */
        function getComplete(response) {
            return response.data;
        }

        /**
         * GetFailed
         *
         * This method is used to get the response from the endpoint in unsuccesfull case 
         *
         * @param object data
         * @return 
         */
        function getFailed(error) {
            return {
                error: true,
                message: error
            };
        }


    }
})();