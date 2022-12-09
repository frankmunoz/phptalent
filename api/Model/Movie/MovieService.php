<?php
/**
 * Manages all events of Movies section with the Json File
 *
 * This class is used to retrieve and send the data with Json File 
 * where the data is stored
 *
 * @version 1.0
 * @author Francisco Muñoz
 */
class MovieService extends NoSQL {

    const ZERO = 0;

    public function __construct() {
        $this->entity = 'movie';
        parent::__construct();
    }

    /**
     * Get all movies list  
     *
     * This method is used to get all movies from Json File
     *
     * @param object 
     * @return object with structure to show if the transaction was successful or not
     */
    public function get() {
        try {
            return $this->getJSONFromTable();
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Filter by title 
     *
     * This method is used to filtermovies according with the criteria param title
     *
     * @param object $result, $params
     * @return object with structure to show if the transaction was successful or not
     */
    private function filterByTitle($result, $params){
        return array_values(array_filter($result, function ($item) use ($params) {
            return HelperString::strPosition($item->Title, $params->criteria) !== false;
            if (HelperString::strPosition($item->Title, $params->criteria) !== false){
                return true;
            }
        }));
    }
   
    /**
     * Filter by Year
     *
     * This method is used to filter the json gile according criteria field year
     *
     * @param object $result, $params
     * @return object with structure to show if the transaction was successful or not
     */
    private function filterByYear($result, $params){
        return array_values(array_filter($result, function ($item) use ($params) {
            return !empty($params->from) && !empty($params->to) && $item->Year >= $params->from && $item->Year <= $params->to;
        }));
    }

    /**
     * Filter by criteria 
     *
     * This method is used to filter the json gile according criteria field
     *
     * @param object $params
     * @return object with structure to show if the transaction was successful or not
     */
    public function filter($params) {
        $result = [];
        try {
            $result = $this->getJSONFromTable();
            $result = !empty($params->criteria) ? $this->filterByTitle($result, $params) : $result;
            $result = !empty($params->from) || !empty($params->to) ? $this->filterByYear($result, $params) : $result;
            $result = !empty($params->orderBy) && !empty($params->order) ? HelperString::array_msort($result, array($params->orderBy => ($params->order === 'Ascending' ? SORT_ASC : SORT_DESC) ) ) : $result;
            return $result;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Truncate and populate data into Json DB File
     *
     * This method is used to truncate and populate data into Json File
     *
     * @param object $data
     * @return object with structure to show if the transaction was successful or not
     */
    public function post($data) {
        try {
            $totalRows = $this->truncateAndPopulate($data->Search);
            return $totalRows;
            return ['rows'=>$totalRows];
        } catch (Exception $exc) {  
            return false;
        }
    }

    /**
     * Get the data from URI
     *
     * This method is used to get the data from URI
     *
     * @param object $data
     * @return object with structure to show if the transaction was successful or not
     */
    public function getCollection() {
        try {
            $endPoint = 'https://www.omdbapi.com/?s=avengers&apiKey=fc59da33';
            return $this->getJSONFromURI($endPoint);
        } catch (Exception $exc) {
            return false;
        }
    }

}
