<?php
namespace SeniorProgramming\Fancourier\Services;

use SeniorProgramming\FanCourier\Core\Base;
use SeniorProgramming\FanCourier\Helpers\Hints;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInstanceException;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;
use SeniorProgramming\FanCourier\Exceptions\FanCourierUnknownModelException;

class ApiService extends Base {
    
    
    private $credentials;

    /**
     * 
     * @throws FanCourierInvalidParamException
     */
    public function __construct() {
        if(!config('fancourier.username') || !config('fancourier.password') || !config('fancourier.client_id')) {
            throw new FanCourierInvalidParamException('Please set FANCOURIER_USERNAME, FANCOURIER_PASSWORD and FANCOURIER_CLIENT_ID environment variables.');
        }
        
        $this->credentials = (object) [
            'username'  => config('fancourier.username'),
            'user_pass'  => config('fancourier.password'),
            'client_id' => config('fancourier.client_id'),
            ];
    }
    
    /**
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws FanCourierUnknownModelException
     * @throws FanCourierInstanceException
     */
    public function __call($method, $args = array()) {
        
        $instance = parent::instantiate(ucfirst($method));
        
        if(!is_callable([$instance, 'set'])) {
            throw new FanCourierUnknownModelException("Method $method does not exist");
        }
        
        try {
            return parent::makeRequest($this->credentials, call_user_func_array([$instance, 'set'], $args));
        } catch (Exception $ex) {
            throw new FanCourierInstanceException("Invalid request");
        }
    }
    
    public function csvImportHelper() {
        return Hints::importCsvKeys();
    }
}


