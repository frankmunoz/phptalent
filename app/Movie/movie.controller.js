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

        function activate() {
            MovieService.get().then(function (data) {
                vm.movieCollection = data.data;
                vm.totalRows = data.data.totalRows;
            });
        }

        function __retrieve() {
            MovieService.retrieve().then(function (data) {
                vm.movieCollection = data.data.result;
                alert("Importados " + vm.movieCollection.length +  " registros" );
            });
        }

        function __filter() {
            MovieService.filter(vm.search).then(function (data) {
                vm.movieCollection = data.data.result;
                vm.totalRows = data.data.totalRows;
            });
        }
    }
})();
