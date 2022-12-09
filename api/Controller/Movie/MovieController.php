<?php

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

    public function post() {
        $data = $this->getInputDataStream();
        try {
            $this->movieService->post($data->movie);
            $this->response($data, self::OK);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function put() {
        $data = $this->getInputDataStream();
        try {
            $this->movieService->put($data->movie);
            $this->response($data, self::OK);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function delete() {
        try {
            $id = $this->getUriSegment();
            $data = $this->movieService->delete($id);
            if(count($data)){
                $this->response($data, self::OK);
            }
            $this->response('', self::NO_CONTENT);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    
}
