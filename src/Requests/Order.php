<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\Fancourier\Exceptions\FanCourierInvalidParamException;

class Order extends Endpoint {
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'comanda_curier_integrat.php';
    }
    
    /**
     * 
     * @return string
     */
    public function fetchResults() 
    {
        return 'plain';
    }
    
    /**
     * 
     * @param array $params
     * @return boolean
     * @throws FanCourierInvalidParamException
     */
    public function validate($params)
    {
        $fetched_params = $this->methodRequirements();
        $optional = [];
        if ( !empty($fetched_params['optional'])) {
            $optional = $fetched_params['optional'];
            unset($fetched_params['optional']);
        }
        $only_one = [];
        if ( !empty($fetched_params['at_least'])) {
            $only_one = $fetched_params['at_least'];
            unset($fetched_params['at_least']);
        }
        
        if (count(array_diff($fetched_params, array_keys($params))) > 0 ||
            (count(array_diff($only_one, array_keys($params))) != 1) ||
            (count(array_diff($only_one, array_merge(array_intersect(array_keys($params), $only_one), array_diff($only_one, array_keys($params))))) > 0) ||
            (count(array_diff(array_keys($params), array_merge($fetched_params, $optional, $only_one))) > 0) ) {
            throw new FanCourierInvalidParamException('These fields are mandatory: ' . implode(', ', $fetched_params) . '. ' . (empty($only_one) ? '' : 'With one of these fields: '. implode(', ', $only_one) . '. ').(empty($optional) ? '' : 'With only these optionals: '. implode(', ', $optional) . '. ') ) ;
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
            'pers_contact',
            'tel',
            'email',
            'greutate', //necesar, pentru plicuri introduceti 1
            'inaltime', //necesar numai pentru colete sau daca greutate > 1
            'lungime', //necesar numai pentru colete sau daca greutate > 1
            'latime', //necesar numai pentru colete sau daca greutate > 1
            'ora_ridicare',  //necesar, de forma: hh:mm
            'at_least' => [
                'nr_plicuri', //optional, trebuie specificat cel putin un colet/plic
                'nr_colete', //optional, trebuie specificat cel putin un colet/plic
            ],
            'optional' => [
                'observatii',
                'client_exp', //numele clientului expeditor, diferit de numele sucursalei
                'strada', //optional, se completeaza numai pentru comenzile cu adresa de ridicare diferita de adresa clienutlui
                'nr', 
                'bloc',
                'scara',
                'etaj',
                'ap',
                'localitate', //necesar cand se completeza strada
                'judet', //necesar cand se completeza strada
            ], 
        ];
    }
    
}

