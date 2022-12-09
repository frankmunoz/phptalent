<?php
/**
 * Manages all events of authentication section of API endpoints 
 *
 * This class is used to retrieve and send the data according with the 
 * given endpoint with HTTP Verb.
 *
 * @version 1.0
 * @author Francisco Muñoz
 */

class AuthenticationController extends Rest {

    private $authenticationService;
    private $response;

    public function __construct() {
        $this->authenticationService = new AuthenticationService();
    }

    /**
     * Register a new user 
     *
     * This method is used to insert new user with method POST
     *
     * @param object $data->register 
     * @return $json with structure to show if the transaction was successful or not
     */
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

    /**
     * Login an user 
     *
     * This method is used to login user with method POST
     *
     * @param object $data->login 
     * @return object with structure to show if the transaction was successful or not
     */
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

    /**
     * Logout an user 
     *
     * This method is used to logout user with method POST
     *
     * @param object $data->register 
     * @return 
     */
    public function logout() {
        session_destroy();
    }

    private function validateLoginForm($login){
        $this->validateUsernameField(trim($login->username));
        return count($this->response)?FALSE:TRUE;
    }

    /**
     * Validate each field in Regster Form
     *
     * This method is used to call validations for each field 
     *
     * @param object $register
     * @return boolean according with the validation
     */
    private function validateRegisterForm($register){
        $this->validateUsernameField(trim($register->username));
        $this->validatePhoneField(trim($register->phone));
        $this->validateEmailField(trim($register->email));
        $this->validatePasswordField(trim($register->password));
        return count($this->response)?FALSE:TRUE;
    }

    /**
     * Validate username field in Regster Form
     *
     * This method is used to validate username field 
     *
     * @param object $username
     * @return array with field and message error
     */
    private function validateUsernameField($username){
        if(empty(($username))){
            $this->response['username'][] = "The username field is empty";
        }
        if(!ctype_alpha($username)){
            $this->response['username'][] = "The username field must contains only letters";
        }
    }

    /**
     * Validate email field in Regster Form
     *
     * This method is used to validate email field 
     *
     * @param object $email
     * @return array with field and message error
     */
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

    /**
     * Validate phone field in Regster Form
     *
     * This method is used to validate phone field 
     *
     * @param object $phone
     * @return array with field and message error
     */
    private function validatePhoneField($phone){
        $pattern = "/^[+][0-9]/";
        if(!preg_match($pattern,$phone)){
            $this->response['phone'][] = "The phone number field is not valid";
        }
    }

    /**
     * Validate password field in Regster Form
     *
     * This method is used to validate password field 
     *
     * @param object $password
     * @return array with field and message error
     */
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
