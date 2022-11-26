<?php

class MovieService extends NoSQL {

    const ZERO = 0;

    public function __construct() {
        $this->entity = 'movie';
        parent::__construct();
    }

    public function get() {
        try {
            return $this->getJSONFromTable();
        } catch (Exception $exc) {
            return false;
        }
    }

    private function filterByTitle($result, $params){
        return array_values(array_filter($result, function ($item) use ($params) {
            return HelperString::strPosition($item->Title, $params->criteria) !== false;
            if (HelperString::strPosition($item->Title, $params->criteria) !== false){
                return true;
            }
        }));
    }

    private function filterByYear($result, $params){
        return array_values(array_filter($result, function ($item) use ($params) {
            return !empty($params->from) && !empty($params->to) && $item->Year >= $params->from && $item->Year <= $params->to;
        }));
    }

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

    public function post($data) {
        try {
            $totalRows = $this->truncateAndPopulate($data->Search);
            return $totalRows;
            return ['rows'=>$totalRows];
        } catch (Exception $exc) {  
            return false;
        }
    }

    public function getCollection() {
        try {
            $endPoint = 'https://www.omdbapi.com/?s=avengers&apiKey=fc59da33';
            return $this->getJSONFromURI($endPoint);
        } catch (Exception $exc) {
            return false;
        }
    }

}
