<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;

class TrackAwb extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'awb_tracking_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() {
        return 'plain';
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
            'AWB', 
            'display_mode' //1 – afisarea ultimului status, 2 – afisarea ultimei inregistrari din istoricul traseului, 3 – afisarea intregului istoric al traseului
        ];
    }
}

