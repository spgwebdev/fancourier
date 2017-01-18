<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;

class DownloadAwb extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'download_awb_scan_integrat.php';
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
            'AWB', //numarul de AWB al expeditiei
            'optional' => [
                'language',
            ],
        ];
    }
}

