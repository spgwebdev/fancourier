<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;

class ExportAwbErrors extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'export_lista_erori_imp_awb_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() 
    {
        return 'csv';
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

