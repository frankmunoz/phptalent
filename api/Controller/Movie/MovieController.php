<?php
/**
 * Manages all events of Movie section of API endpoints
 *
 * This class is used to retrieve and send the data according with the 
 * given endpoint with HTTP Verb.
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class MovieController extends Rest {

    private $movieService;

    public function __construct() {
        session_start();
 
        if(!isset($_SESSION['user'])){
            header('Location: ./');
            exit;
        } else {
            $this->movieService = new MovieService();
        }
    }

    /**
     * Get all the movies from Json DB file
     *
     * This method is used to geet all the movies with method GET
     *
     * @param 
     * @return object with structure to show if the transaction was successful or not
     */
    public function get() {
        try {
            $data = $this->movieService->get();
            if(count($data)){
                $this->response($data, self::OK);
            }
            $this->response([], self::OK);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * filter the movies 
     *
     * This method is used to filter the movies according with the criterias
     *
     * @param object with the criterias params to filter
     * @return object with structure to show if the transaction was successful or not
     */
    public function filter() {
        try {
            $params = $this->getInputDataStream();
            $data = $this->movieService->filter($params);
            if(count($data)){
                $dataResult = [
                    'result' => $data
                    , 'totalRows' => count($data)
                ];
            }               
            $this->response($dataResult, self::OK);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Get all the movies from URI 
     *
     * This method is used to geet all the movies with method GET
     *
     * @param 
     * @return object with structure to show if the transaction was successful or not
     */
    public function getCollection() {
        try {
            $data = $this->movieService->getCollection();
            if(count($data)){
               $rows = $this->movieService->post($data);
               $dataResult = [
                    'result' => $data->Search
                    , 'insertedRows' => $rows
               ];
               $this->response($dataResult, self::OK);
            }
            $this->response('', self::NO_CONTENT);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
