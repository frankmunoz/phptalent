<?php
/**
 * Manages all events of authentication section with the Json File
 *
 * This class is used to retrieve and send the data with Json File 
 * where the data is stored
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class AuthenticationService extends NoSQL {

    const ZERO = 0;

    public function __construct() {
        $this->entity = 'user';
        $this->pk = 'username';
        parent::__construct();
    }

    /**
     * Register a new user 
     *
     * This method is used to insert new user into Json File
     *
     * @param object $data
     * @return object with structure to show if the transaction was successful or not
     */
    public function post($data) {
        try {
            $data->password = md5($data->password);
            return $this->insert($data);
        } catch (Exception $exc) {  
            return false;
        }
    }

    /**
     * Login an user 
     *
     * This method is used to validate the login data to get acces and create the session
     *
     * @param object $data
     * @return object with structure to show if the transaction was successful or not
     */
    public function login($data) {
        try {
            $data->password = md5($data->password);
            $json = $this->getJSONFromTable();
            $records = json_decode(json_encode($json), TRUE);
            $pk = $this->pk;
            foreach($records AS $record){
                if($record['username'] === $data->username && $record['password'] === $data->password){
                    return ['error'=>FALSE, 'message'=>['Login successfull']];
                }
            }
            return ['error'=>TRUE, 'message'=>["username"=>['Username and password do not match or you do not have an account yet']]];
        } catch (Exception $exc) {  
            return false;
        }
    }
}