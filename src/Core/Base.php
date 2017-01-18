<?php

namespace SeniorProgramming\FanCourier\Core;

use SeniorProgramming\FanCourier\Core\BaseInterface;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInstanceException;
use SeniorProgramming\FanCourier\Exceptions\FanCourierUnknownModelException;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;
use \Curl\Curl;
use SeniorProgramming\FanCourier\Helpers\Csv;

abstract class Base  implements BaseInterface {
    
    protected $instance;
    
    /**
     * 
     * @param string $class
     * @return \SeniorProgramming\FanCourier\Requests\class_call
     * @throws FanCourierUnknownModelException
     */
    public function instantiate ($class)
    {
        $class_call = "SeniorProgramming\\FanCourier\\Requests\\" . $class;
        if (!class_exists($class_call)) {
            throw new FanCourierUnknownModelException("Class $class_call does not exist");
        }
        return new $class_call();
    }
    
    
    /**
     * 
     * @param array $credentials
     * @param \SeniorProgramming\FanCourier\Requests\class_call $object
     * @return string
     * @throws FanCourierInvalidParamException
     */
    public function makeRequest($credentials, $object) 
    {
        if (!is_object($object) && empty($object)) {
            throw new FanCourierInvalidParamException("Invalid object");
        }
        
        if (!in_array($object->fetchResults(), $this->checkResultType())) {
            throw new FanCourierInvalidParamException("Invalid result type");
        }
        $url = $this->getUrl($object);
        $this->instance = $object;
        
        $params = (array) $object;
        if (isset($params['callMethod'])) {
            unset($params['callMethod']);
        }
        
        if (is_callable([$this->instance, 'convertInCsv']) && !empty($this->instance->convertInCsv())) {
            $params = Csv::convertToCSV($this->instance->getParams(), $this->instance->convertInCsv());
        }
        
        $params += (array) $credentials;
        return $this->postCurlRequest($params, $url, $object->fetchResults());
    }
    
    /**
     * 
     * @param array $data
     * @param string $url
     * @param string $resultType
     * @return string
     * @throws FanCourierInstanceException
     */
    private function postCurlRequest ($data, $url, $resultType)
    {
        
        $this->checkParams($data);
        $this->checkUrl($url);
        
        $curl = new Curl();
        $curl->post($url, $data);
        if ($curl->error) {
            throw new FanCourierInstanceException('Invalid curl error. Code: '. $curl->errorCode . '. Message: '. $curl->errorMessage);
        } else {
            return $this->getResultType($resultType, $curl->response);
        }
        
    }
    
    /**
     * 
     * @param \SeniorProgramming\FanCourier\Requests\class_call $object
     * @return string
     * @throws FanCourierInstanceException
     */
    private function getUrl($object) 
    {
        if (empty($object->callMethod)) {
            throw new FanCourierInstanceException("Unset url request");
        } 
        
        return $object->callMethod;
    }
    
    /**
     * 
     * @param string $url
     * @throws FanCourierInstanceException
     */
    private function checkUrl ($url) 
    {
        
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new FanCourierInstanceException("Invalid url request");
        } 
    }
    
    /**
     * 
     * @param array $data
     * @throws \Exception
     */
    private function checkParams ($data) 
    {
        
        if (!is_array($data) && empty($data)) {
            throw new \Exception("Invalid params");
        }
        
        if (!is_array($data) && empty($data)) {
            throw new \Exception("Invalid params");
        }
        
        if (empty($data['username']) ||  empty($data['user_pass']) || empty($data['client_id'])) {
            throw new \Exception("Invalid credentials");
        }
    }
    
    
    /**
     * 
     * @return array
     */
    private function checkResultType ()
    {
        return ['csv', 'plain', 'bool', 'parse', 'html'];
    }
    
    /**
     * 
     * @param string $type
     * @param string $result
     * @return string|bool
     */
    private function getResultType($type, $result)
    {
        switch ($type) {
            case 'csv' : 
                return Csv::stringToObjects($result);
            case 'bool' :
                return is_callable([$this->instance, 'parseResult']) ? $this->instance->parseResult($result) : false;
            case 'parse' :
                return is_callable([$this->instance, 'parseResult']) ? $this->instance->parseResult($result) : $result;
            case 'html' :
                return is_callable([$this->instance, 'parseResult']) ? $this->instance->parseResult($result) : $result;
            default :
                return $result;
        }
    }
}
