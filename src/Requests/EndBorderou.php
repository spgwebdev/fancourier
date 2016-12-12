<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\Fancourier\Exceptions\FanCourierInvalidParamException;

class EndBorderou extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'finalizare_borderou_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() 
    {
        return 'html';
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     * @throws FanCourierInvalidParamException
     */
    public function validate($params = array())
    {
        if (!empty($params)) 
            throw new FanCourierInvalidParamException('No fields required');
        
        return true;
    }
}

