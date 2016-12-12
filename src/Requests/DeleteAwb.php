<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;

class DeleteAwb extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'delete_awb_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() {
        return 'parse';
    }
    
    /**
     * 
     * @param string $result
     * @return int|string
     */
    public function parseResult($result) 
    {
        if (strpos(strtolower($result), 'deleted') !== false) {
            return (int) str_replace('deleted', '', strtolower($result));
        }
        return $result;
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     */
    public function validate($params = array())
    {
        parent::requiredParams(array_keys($params), $this->methodRequirements());
        return true;
        
    }
    
    /**
     * 
     * @return array
     */
    private function methodRequirements() 
    {
        return [
            'AWB', 
        ];
    }
}

