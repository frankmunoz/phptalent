/**
 * Authentication Service
 * @namespace AuthenticationService
 * @memberOf Service
 */
(function () {
    'use strict';

    angular
            .module('app.authentication')
            .factory('AuthenticationService', AuthenticationService);

    AuthenticationService.$inject = ['$http'];

    /**
     * @namespace AuthenticationService
     * @param $http
     * @memberOf authentication
     */
    function AuthenticationService($http) {
        var urlService = 'api/';

        var service = {
            get: __get,
            post: __post,
            login: __login,
            logout: __logout
        };

        return service;

        function __get() {
            var url = urlService + "authentication";
            return $http({
                url: url,
                method: 'GET'
            })
                    .then(getComplete)
                    .catch(getFailed);
        }

        function __post(register) {
            return $http.post(urlService + 'authentication/register/', register)
                    .then(getComplete)
                    .catch(getFailed);
        }

        function __login(login) {
            return $http.post(urlService + 'authentication/login/', login)
                    .then(getComplete)
                    .catch(getFailed);
        }

        function __logout() {
            return $http.post(urlService + 'authentication/logout/', {})
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