<?php

class NoSQL {
    public $table = NULL;
    public $entity = '';
    private $file = '';
    public $dbFolder = 'Database';

    public function __construct() {
        $this->file = $this->dbFolder . '/' . $this->entity . '.json';
    }

    public function truncateAndPopulate($data){
        try {
            $this->table = fopen($this->file, 'wa+');
            fwrite($this->table, json_encode($data));
            fwrite($this->table, PHP_EOL);
            foreach ($data as $row){
                $i++;
            }
            fclose($this->table);
            return $i;
        } catch (Exception $exc) {  
            return false;
        }
    }

    public function getJSONFromTable(){
        try {
            return $this->getJSONFromURI($this->file);
        } catch (Exception $exc) {  
            return false;
        }
    }

    public function getJSONFromURI($endPoint){
        try {
            $json = file_get_contents($endPoint);
            return $this->json($json);
        } catch (Exception $exc) {  
            return false;
        }
    }

    public function json($data) {
        return json_decode($data);
    }


}
