<?php

class NoSQL {
    public $table = NULL;
    public $entity = '';
    public $pk = '';
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

    public function insert($data){
        try {
            $json = $this->getJSONFromTable();
            $records = json_decode(json_encode($json), TRUE);
            $pk = $this->pk;
            foreach($records AS $record){
                if($record[$this->pk] === $data->$pk){
                    return ['error'=>TRUE, 'message'=>["username"=>[$this->pk . ' field is already exists']]];
                }
            }

            $records[] = $data;
            $totalRows = $this->truncateAndPopulate($records);
            return ['error'=>FALSE, 'message'=>'Record saved succesfully'];
            return [$this->entity=>$data, 'rows'=>$totalRows];
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
