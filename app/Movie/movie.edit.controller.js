/**
 * MovieEdit Controller
 * @namespace MovieEdit
 * @memberOf Controllers
 */
(function () {
    'use strict';

    angular
            .module('app.movie')
            .controller('MovieEditCtrl', MovieEditCtrl);

    MovieEditCtrl.$inject = ['MovieService', 'RoomService','$routeParams', '$rootScope', '$location'];

    /**
     * @namespace MovieEditCtrl
     * @desc MovieEdit Controller
     * @memberOf MovieEdit.Controller
     */
    function MovieEditCtrl(MovieService, RoomService, $routeParams, $rootScope, $location) {
        var vm = this;
        vm.data = {};
        vm.save = __save;
        vm.delete = __delete;
        vm.assignRoom = __checkIn;
        vm.assignLabel = "Buscar habitaciones disponibles"
        vm.findRoom = false;
        activate();

        function activate() {
            vm.movieId = ($routeParams.movieId) ? parseInt($routeParams.movieId) : 0;
            $rootScope.title = (vm.movieId > 0) ? 'Editar Paciente' : 'Crear Paciente';
            vm.buttonText = (vm.movieId > 0) ? 'Actualizar Paciente' : 'Crear Nuevo Paciente';
            MovieService.getMovie(vm.movieId).then(function (data) {
                vm.data = data.data;
                console.log(vm.data);
                vm.assignRoomButtonText = (vm.data.room_id != null) ? 'Dar de alta de ' + vm.data.room_number : vm.assignLabel;
                vm.assignRoom = (vm.data.room_id != null) ? __checkOut : __checkIn;
            });
        }

        function onFrmComplete(data, field) {
            if (!data.success) {
                console.log("NO SUCCESS");
            } else {
                $location.path('/movies');
                console.log("OK");
            }
        }

        function onFrmFailed(error) {
            console.log("ERROR");
        }

    }
})();
