/**
 * Movie Controller
 * @namespace Movie
 * @memberOf Controllers
 */
(function () {
    'use strict';

    angular
            .module('app.movie')
            .controller('MovieCtrl', MovieCtrl);

            MovieCtrl.$inject = ['MovieService', '$location'];

    /**
     * @namespace MovieCtrl
     * @desc Movie Controller
     * @memberOf Movie.Controller
     */
    function MovieCtrl(MovieService, $location) {
        var vm = this;
        vm.movieCollection = {};
        vm.retrieve = __retrieve;
        vm.filter = __filter;

        activate();

        /**
         * activate
         *
         * This method is the constructor of this js class get all the movies
         *
         * @param 
         * @return object with structure response
         */
        function activate() {
            MovieService.get().then(function (data) {
                try {
                    vm.movieCollection = data.data;
                    vm.totalRows = data.data.totalRows;
                } catch (error) {
                    onRequestFailed();
                }
            }).catch(onRequestFailed);
        }

        /**
         * Retrieve
         *
         * This method is used to retieve all the Movies from the backend endpoint
         *
         * @param 
         * @return object with structure response
         */
        function __retrieve() {
            MovieService.retrieve().then(function (data) {
                vm.movieCollection = data.data.result;
                alert("Importados " + vm.movieCollection.length +  " registros" );
            }).catch(onRequestFailed);
        }

        /**
         * Filter
         *
         * This method is used to filter the Movies from the backend endpoint
         *
         * @param object data
         * @return object with structure response
         */
        function __filter() {
            MovieService.filter(vm.search).then(function (data) {
                vm.movieCollection = data.data.result;
                vm.totalRows = data.data.totalRows;
            }).catch(onRequestFailed);
        }

        /**
         * OnRequestFailed
         *
         * This method is used to get the response from the endpoint in unsuccesfull case 
         *
         * @param object data
         * @return 
         */
        function onRequestFailed(data){
            $location.path('/');
        }
    }
})();
