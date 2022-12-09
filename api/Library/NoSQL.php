<?php
/**
 * Manages all events of transactions with the Json File
 *
 * This class is used to retrieve and send the data with Json File 
 * where the data is stored according with the entity
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class NoSQL {
    public $table = NULL;
    public $entity = '';
    public $pk = '';
    private $file = '';
    public $dbFolder = 'Database';

    public function __construct() {
        $this->file = $this->dbFolder . '/' . $this->entity . '.json';
    }

    /**
     * Truncate and populate data into Json DB File
     *
     * This method is used to truncate and populate data into Json File
     *
     * @param object $data
     * @return integer number of register
     */
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

    /**
     * Insert data into Json DB File
     *
     * This method is used to insert data into Json File
     *
     * @param object $data
     * @return object with structure to show if the transaction was successful or not
     */
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

    /**
     * Get Json data according with the file of the entity
     *
     * This method is used to retrieve data from Json File according with the file of the entity
     *
     * @param object 
     * @return object with structure to show if the transaction was successful or not
     */
    public function getJSONFromTable(){
        try {
            return $this->getJSONFromURI($this->file);
        } catch (Exception $exc) {  
            return false;
        }
    }

    /**
     * Get the Json data from URI
     *
     * This method is used to get the data from URI
     *
     * @param object $endPoint
     * @return object json content file
     */
    public function getJSONFromURI($endPoint){
        try {
            $json = file_get_contents($endPoint);
            return $this->json($json);
        } catch (Exception $exc) {  
            return false;
        }
    }

    /**
     * Json decode
     *
     * This method is used to decode  Json data
     *
     * @param object $data
     * @return object json decoded
     */
    public function json($data) {
        return json_decode($data);
    }


}
