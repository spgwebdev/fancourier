<?php

namespace SeniorProgramming\FanCourier\Core;

use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;
use SeniorProgramming\FanCourier\Core\EndpointInterface;


abstract class Endpoint implements EndpointInterface {
    
    /**
     * 
     * @param array $params
     * @return array
     * @throws FanCourierInvalidParamException
     */
    public function set($params = array())
    {
        if (!is_array($params)) {
            throw new FanCourierInvalidParamException('Require array');
        }
        
        $this->validate($params);
        return $this->requirements($params);
    }
    
    /**
     * 
     * @param array $params
     * @return \SeniorProgramming\FanCourier\Core\Endpoint
     */
    protected function requirements($params) 
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        $this->callMethod = $this->url() . $this->getCallMethod();
        
        return $this;
    }
    
    /*
     * 
     */
    public function __set($name, $value) 
    {
        $this->$name = $value;
    }
    
    /*
     * 
     */
    public function __get($name) 
    {
        return $this->$name;
    }
    
    /**
     * 
     * @param array $set
     * @param array $required
     * @throws FanCourierInvalidParamException
     */
    protected function requiredParams($set, $required)
    {
        if (count(array_diff($required, $set)) > 0 || count(array_diff($set, $required)) > 0) {
            throw new FanCourierInvalidParamException('The only keys acceptted are: ' . implode(', ', $required));
        }
    }
    
    /**
     * 
     * @param array $set
     * @param array $accepted
     * @throws FanCourierInvalidParamException
     */
    protected function optionalParams($set, $accepted)
    {
        if (count(array_diff($accepted, $set)) > (count($accepted) -1) || 
            in_array($accepted, array_merge(array_diff($accepted, $set), array_intersect($set, $accepted))) || 
            (!empty(array_diff($set, $accepted)) && !in_array(array_diff($set, $accepted), $accepted))) {
                throw new FanCourierInvalidParamException('The only keys acceptted are: ' . implode(', ', $accepted));
        }
    }


    private function url ()
    {
        return 'https://www.selfawb.ro/';
    }
    
    abstract public function fetchResults();
    
    abstract public function validate($params);
    
    abstract protected function getCallMethod();
    
    
    
    
}



