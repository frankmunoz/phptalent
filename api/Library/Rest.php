<?php
/**
 * Manages all events of API endpoints 
 *
 * This class is used to manage all the logic of REST Filosphy with 
 * verbs of requests
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class Rest {

    public $_allow = array();
    public $_content_type = "application/json";
    public $_request = array();
    private $_code = 200;

    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const NO_FOUND = 404;
    const NO_ACCEPTABLE = 406;
    const INTERNAL_SERVER_ERROR = 500;

    public function __construct() {
        $this->inputs();
    }

    /**
     * Get HTTP_REFERER
     *
     * This method is used to referer get the optional HTTP header field 
     * that identifies the address of the web page from which the request is made. 
     *
     * @param
     * @return  
     */
    public function getReferer() {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Response request
     *
     * This method is used to build the response with the data and message in json format
     * 
     * @param object $data, $status
     * @return object with structure to show if the transaction was successful or not
     */
    public function response($data, $status) {
        $this->_code = ($status) ? $status : self::OK;
        $this->setHeaders();
        $response = [
            "success" => true,
            "data" => $data
        ];
        echo $this->json($response);
        exit;
    }

    /**
     * Get the status message HTTP
     *
     * This method is used to get the status message according eith the request
     * 
     * @param 
     * @return string $status code
     */
    private function getStatusMessage() {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            404 => 'Not Found',
            406 => 'Not Acceptable');
        return ($status[$this->_code]) ? $status[$this->_code] : $status[self::INTERNAL_SERVER_ERROR];
    }

    /**
     * Get the request method
     *
     * This method is used to get the request method
     * 
     * @param  
     * @return string with the request method
     */
    public function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get URI segment
     *
     * This method is used to get the segment from the URI request
     * 
     * @param  
     * @return object with segment
     */
    public function getUriSegment() {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        return array_pop($uri_segments);
    }

    /**
     * Get the URI params 
     *
     * This method is used to get the params from the HTTP request
     * 
     * @param  
     * @return object with structure of params
     */
    protected function getInputDataStream() {
        return json_decode(file_get_contents("php://input"));
    }

    /**
     * Get request params
     *
     * This method is used to get request params according eith the request HTTP
     * 
     * @param  
     * @return object with structure of request HTTP 
     */
    private function inputs() {
        switch ($this->getRequestMethod()) {
            case "POST":
                $this->_request = $this->cleanInputs($_POST);
                break;
            case "GET":
            case "DELETE":
                $this->_request = $this->cleanInputs($_GET);
                break;
            case "PUT":
                parse_str(file_get_contents("php://input"), $this->_request);
                $this->_request = $this->cleanInputs($this->_request);
                break;
            default:
                $this->response('', self::NO_ACCEPTABLE);
                break;
        }
    }

    /**
     * Clean the request data
     *
     * This method is used to clean the request data to avoid hacking
     * 
     * @param object $data
     * @return object with structure params
     */
    private function cleanInputs($data) {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }

    /**
     * Set Headers
     *
     * This method is used to set the headers according with the content type
     * 
     * @param  
     * @return 
     */
    private function setHeaders() {
        header("HTTP/1.1 " . $this->_code . " " . $this->getStatusMessage());
        header("Content-Type:" . $this->_content_type);
    }

    /**
     * Json encode
     *
     * This method is used to encode  Json data
     *
     * @param object $data
     * @return object json encoded
     */
    public function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}
