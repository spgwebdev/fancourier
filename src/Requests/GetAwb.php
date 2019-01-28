<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;

class GetAwb extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'view_awb_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() {
        return 'html';
    }
    
    /**
     * 
     * @param string $result
     * @return int|string
     */
    public function parseResult($result) 
    {
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
            'nr', //AWB,
            'type'
        ];
    }
}

