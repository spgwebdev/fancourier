<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\FanCourier\Helpers\Hints;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;

class GenerateAwb extends Endpoint {
    
    protected $keys;
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'import_awb_integrat.php';
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
        $parse = str_getcsv($result, "\n");
        $return_result = [];
        if (empty($parse)) {
            return $result;
        }
        
        try {
            foreach ($parse as $value) {
                $result_per_row = explode(',', $value);
                $return_result[] = (object) ['line' => $result_per_row[0], 
                    'awb' => $result_per_row[1] == 1 ? $result_per_row[2] : false, 
                    'send_params' => current(array_values($this->keys))[$result_per_row[0]],
                    'error_message' => $result_per_row[1] == 1 ? '' : $result_per_row[2] ];
            }
        } catch (Exception $ex) {

        }
        
        return $return_result;
    }
    
    /**
     * 
     * @return boolean
     */
    public function convertInCsv() {
        return Hints::importCsvValues();
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     * @throws FanCourierInvalidParamException
     */
    public function validate($params = array())
    {
        parent::requiredParams(array_keys($params), $this->methodRequirements());
        $keys_hint = Hints::importCsvKeys();
        foreach($this->methodRequirements() as $key) {
            if (empty($params[$key])) {
                throw new FanCourierInvalidParamException('Must define the following key: ' . $key . '. ' ) ;
            }
            
            $i = 1;
            foreach ($params[$key] as $val) {
                if (empty($val) || !is_array($val) || (count(array_diff($keys_hint, array_keys($val))) != 0 && count(array_diff($keys_hint, array_keys($val))) > (count($keys_hint) - 1))) {
                    $this->keys = [];
                    throw new FanCourierInvalidParamException('You must define at least one key. Eg.: ' . implode(', ', $keys_hint) . '. ' ) ;
                }
                foreach($keys_hint as $v) {
                    $this->keys[$key][$i][$v] = !empty($val[$v]) ? $val[$v] : '';
                    
                }
                $i++;
            }
        }
        return true;
        
    }
    
    public function getParams()
    {
        return $this->keys;
    }
    
    /**
     * 
     * @return array
     */
    private function methodRequirements() 
    {
        return [
            'fisier', //acesta este fisierul care contine datele despre expeditiile de importat;fisierul se creeaza conform modelului pentru import AWB-uri in aplicatia FAN, poate contine una sau mai multe inregistrari (expeditii) si poate fi descarcat din aplicatie.
        ];
    }
}

