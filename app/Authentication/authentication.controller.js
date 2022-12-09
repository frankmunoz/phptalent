/**
 * Authentication Controller
 * @namespace Authentication
 * @memberOf Controllers
 */
(function () {
    'use strict';

    angular
            .module('app.authentication')
            .controller('AuthenticationCtrl', AuthenticationCtrl);

            AuthenticationCtrl.$inject = ['AuthenticationService', '$location'];

    /**
     * @namespace AuthenticationCtrl
     * @desc Authentication Controller
     * @memberOf Authentication.Controller
     */
    function AuthenticationCtrl(AuthenticationService, $location) {
        var vm = this;
        vm.authenticationCollection = {};
        vm.register = __register;
        vm.login = __login;
        vm.errorMessageFrm = '';

        activate();

        function activate() {
        }

        /**
         * Register an user
         *
         * This method is used to register an useer
         *
         * @param 
         * @return object with structure to show if the transaction was successful or not
         */
        function __register() {
            return __post();
        }

        /**
         * Post
         *
         * This method is used to register an user 
         *
         * @param object vm.data
         * @return object with structure to show if the transaction was successful or not
         */
        function __post() {
            return AuthenticationService.post({register: vm.data})
                    .then(function (data) {
                        onFrmComplete(data, vm.data);
                    })
                    .catch(onFrmFailed);

        }

        /**
         * Login
         *
         * This method is used to send the data of login form
         *
         * @param object vm.dataLogin
         * @return object with structure to show if the transaction was successful or not
         */
        function __login(){
            return AuthenticationService.login({login: vm.dataLogin})
                    .then(function (data) {
                        onLoginComplete(data, vm.dataLogin);
                    })
                    .catch(onFrmFailed);
        }

        /**
         * Logout
         *
         * This method is used to close the system session
         *
         * @param 
         * @return
         */
        function __logout(){
            return AuthenticationService.logout()
                    .then(function (data) {
                        console.log(data);
                    })
                    .catch(onFrmFailed);
        }

        /**
         * OnloginComplete
         *
         * This method is used to get the result of the login process and redirect
         *
         * @param object data, field
         * @return object with structure to show if the transaction was successful or not
         */
        function onLoginComplete(data, field){
            if (!data.success) {
                console.log("NO SUCCESS");
            } else {
                let loginMessage = document.getElementById('loginMessage');                
                loginMessage.classList.remove("error");
                loginMessage.innerHTML = "";

                if(data.data.error){
                    for (let field in data.data.message) {
                        let errorMessage = data.data.message[field];
                        loginMessage.classList.add("error");
                        loginMessage.innerHTML = errorMessage[0];
                    }
                }else{
                    vm.data = {};
                    alert("Login succesfull");
                    $location.path('/movies');               
                }
            }
            vm.message = data.message;
        }

        /**
         * OnFrmComplete
         *
         * This method is used to call validations for each field and show the possibles errors in the form
         *
         * @param object data, field
         * @return object with structure to show if the transaction was successful or not
         */
        function onFrmComplete(data, field) {
            if (!data.success) {
                console.log("NO SUCCESS");
            } else {
                //$location.path('/');
                let allInputFields = document.querySelectorAll("input");
                
                try {
                    let allSpan = document.querySelectorAll("span");
                    [].forEach.call(allSpan, function(span) {
                        span.innerHTML = "";
                    });
                } catch (error) {
                }
                [].forEach.call(allInputFields, function(el, i) {
                    el.classList.remove("error");
                    if(data.data.error){
                        try {
                            let spanElement = document.getElementsByTagName("span");
                            el.parentNode.removeChild(el.parentNode.spanElement[i]);                        
                        } catch (error) {
                        }
                    }
                });

                if(data.data.error){
                    for (let field in data.data.message) {
                        let inputField = getElementForm(field);
                        let errorMessage = data.data.message[field];
                        let span = document.createElement('span');
                        
                        inputField.classList.add("error");  
                        span.innerHTML = errorMessage[0]
                        inputField.parentNode.insertBefore(span, inputField);
                    }
                }else{
                    vm.data = {};
                    alert("User registered succesfull");
                }
            }
            vm.message = data.message;
        }

        /**
         * OnFrmFailed
         *
         * This method is used to show the error in case that the request failed 
         *
         * @param object error
         * @return 
         */
        function onFrmFailed(error) {
            console.log("ERROR");
        }    
        
        /**
         * GetElementForm
         *
         * This method is used to get the HTML element of the front page
         *
         * @param string field
         * @return object HTML DOM element
         */
        function getElementForm(field){
            let inputElement = capitalizeString(field);
            let el = document.getElementById('register' + inputElement);
            return el;
        }

        /**
         * capitalizeString
         *
         * This method is used to capitalize a string 
         *
         * @param string str
         * @return string string capitalized
         */
        function capitalizeString(str){
            if(str.length > 0){
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
            return '';
        }
    }
})();
