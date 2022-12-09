<?php

class AuthenticationController extends Rest {

    private $authenticationService;
    private $response;

    public function __construct() {
        $this->authenticationService = new AuthenticationService();
    }

    public function post() {
        $data = $this->getInputDataStream();
        try {
            if($this->validateRegisterForm($data->register)){
                return $this->response($this->authenticationService->post($data->register), self::OK);
            }
            return $this->response(['error'=>TRUE, 'message'=>$this->response], self::OK);
    } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function login() {
        $data = $this->getInputDataStream();
        try {
            if($this->validateLoginForm($data->login)){
                session_start();
                $_SESSION['user'] = $data->login->username;
                return $this->response($this->authenticationService->login($data->login), self::OK);
            }
            return $this->response(['error'=>TRUE, 'message'=>$this->response], self::OK);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function logout() {
        session_destroy();
    }

    private function validateLoginForm($login){
        $this->validateUsernameField(trim($login->username));
        return count($this->response)?FALSE:TRUE;
    }

    private function validateRegisterForm($register){
        $this->validateUsernameField(trim($register->username));
        $this->validatePhoneField(trim($register->phone));
        $this->validateEmailField(trim($register->email));
        $this->validatePasswordField(trim($register->password));
        return count($this->response)?FALSE:TRUE;
    }

    private function validateUsernameField($username){
        if(empty(($username))){
            $this->response['username'][] = "The username field is empty";
        }
        if(!ctype_alpha($username)){
            $this->response['username'][] = "The username field must contains only letters";
        }
    }

    private function validateEmailField($email){
        if(empty($email)){
            $this->response['email'][] = "The email field is empty";
        }
        $pattern = "/([a-zA-Z0-9!#$%&’?^_`~-])+@([a-zA-Z0-9-])+(.com)+/";

        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if(!preg_match($pattern,$email)){
            $this->response['email'][] = "The email field is not valid";
        }
    }

    private function validatePhoneField($phone){
        $pattern = "/^[+][0-9]/";
        if(!preg_match($pattern,$phone)){
            $this->response['phone'][] = "The phone number field is not valid";
        }
    }

    private function validatePasswordField($password){
        if(empty($password)){
            $this->response['password'][] = "The password field is empty";
        }
        $pattern = "/^(?=.*[A-Za-z])[A-Za-z*\-.]{6,}$/";
        if(!preg_match($pattern,$password)){
            $this->response['password'][] = "The password must contain minimum 6 characters, one letter must be Uppercasedand must contain one of these special characters: *  - .";
        }
    }
}
