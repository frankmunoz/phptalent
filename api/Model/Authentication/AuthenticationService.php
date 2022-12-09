<?php

class AuthenticationService extends NoSQL {

    const ZERO = 0;

    public function __construct() {
        $this->entity = 'user';
        $this->pk = 'username';
        parent::__construct();
    }

    public function post($data) {
        try {
            $data->password = md5($data->password);
            return $this->insert($data);
        } catch (Exception $exc) {  
            return false;
        }
    }

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

    public function logout() {
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