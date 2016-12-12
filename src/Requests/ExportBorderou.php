<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\Fancourier\Exceptions\FanCourierInvalidParamException;

class ExportBorderou extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'export_borderou_integrat.php';
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
        $fetched_params = $this->methodRequirements();
        $optional = [];
        if ( !empty($fetched_params['optional'])) {
            $optional = $fetched_params['optional'];
            unset($fetched_params['optional']);
        }
        
        if (count(array_diff($fetched_params, array_keys($params))) > 0 ||  
            (!empty($optional) && count(array_diff(array_diff(array_keys($params), $fetched_params), $optional)) > 0 )  || 
            (empty($optional) && count(array_diff(array_keys($params), $fetched_params)) > 0 ) ) {
                throw new FanCourierInvalidParamException('Must define only the following keys: ' . implode(', ', $fetched_params) . '. ' . (empty($optional) ? '' : 'With only these optionals: '. implode(', ', $optional) . '. ') ) ;
        }
        return true;
    }
    
    /**
     * 
     * @return array
     */
    private function methodRequirements() 
    {
        return [
            'data', //(Data borderoului, de format: dd.mm.yyyy)
            'optional' => [
                'language',
                'mode', //Se poate completa cu valorile 0 (borderoul cu expeditiile generate din selfawb) sau 1 (borderoul cu toate expeditiile self & nonself)
            ], 
        ];
    }
}

