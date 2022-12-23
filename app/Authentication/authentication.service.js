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
            post: __post,
            login: __login,
            logout: __logout
        };

        return service;

        /**
         * Post
         *
         * This method is used to call endpoint to register an user
         *
         * @param object register
         * @return object with structure to show if the transaction was successful or not
         */
        function __post(register) {
            return $http.post(urlService + 'authentication/register/', register)
                    .then(getComplete)
                    .catch(getFailed);
        }

        /**
         * Login
         *
         * This method is used to call endpoint to login an user
         *
         * @param object login
         * @return object with structure to show if the transaction was successful or not
         */
        function __login(login) {
            return $http.post(urlService + 'authentication/login/', login)
                    .then(getComplete)
                    .catch(getFailed);
        }

        /**
         * Logout
         *
         * This method is used to call endpoint to logout
         *
         * @param 
         * @return object with structure to show if the transaction was successful or not
         */
        function __logout() {
            return $http.post(urlService + 'authentication/logout/', {})
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
         * @param object error
         * @return object with structure response
         */
        function getFailed(error) {
            return {
                error: true,
                message: error
            };
        }


    }
})();