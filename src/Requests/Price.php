<?php

namespace SeniorProgramming\Fancourier\Requests;

use SeniorProgramming\FanCourier\Core\Endpoint;
use SeniorProgramming\FanCourier\Exceptions\FanCourierInvalidParamException;
use SeniorProgramming\FanCourier\Exceptions\FanCourierUnknownModelException;

class Price extends Endpoint{
    
    /**
     * 
     * @return string
     */
    protected function getCallMethod()
    {
        return 'tarif.php';
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
     * @throws FanCourierUnknownModelException
     */
    public function validate($params)
    {
        $required_key = 'serviciu';
        $required = [$required_key => array('export', 'standard')];
        
        if (empty($params[$required_key]) || !in_array($params[$required_key], $required[$required_key])) {
            throw new FanCourierInvalidParamException('Must set a "'.$required_key.'" key with one of these values: ' . implode(', ', $required[$required_key]));
        }
        
        if(!is_callable([$this,$params[$required_key].'ServiceRequirements'])) {
            throw new FanCourierUnknownModelException("Undefined {$required_key} type");
        } 
        
        $requires_service = call_user_func([$this, $params[$required_key].'ServiceRequirements']);
        unset($params[$required_key]);
        $optional = [];
        if ( !empty($requires_service['optional'])) {
            $optional = $requires_service['optional'];
            unset($requires_service['optional']);
        }
        
        if (count(array_diff($requires_service, array_keys($params))) > 0 ||  
            (!empty($optional) && count(array_diff(array_diff(array_keys($params), $requires_service), $optional)) > 0 )  || 
            (empty($optional) && count(array_diff(array_keys($params), $requires_service)) > 0 ) ) {
                throw new FanCourierInvalidParamException('Must define only the following keys: ' . implode(', ', $requires_service) . '. ' . (empty($optional) ? '' : 'With only these optionals: '. implode(', ', $optional) . '. ') ) ;
        }
        
        return true;
    }
    
    /**
     * 
     * @return array
     */
    private function standardServiceRequirements()
    {
        return [
            'localitate_dest', //numele localitatii destinatie (cel din baza de date FAN)
            'judet_dest', //numele judetului destinatie (cel din baza de date FAN)
            'plicuri', //numarul de plicuri
            'colete', //numarul de colete
            'greutate', //greutatea totala a expeditiei (kg)
            'lungime', //lungimea coletului (cm)
            'latime', //latimea coletului (cm)
            'inaltime', //inaltimea coletului (cm)
            'val_decl', //valoarea_declarata a expeditiei
            'plata_ramburs', //plata pentru ramburs la „destinatar” sau „expeditor”  
            'optional' => [
                'plata_la' // //plata expeditiei la „destinatar” sau „expeditor” (optional)
            ], 
        ];
    }
    
    /**
     * 
     * @return array
     */
    private function exportServiceRequirements()
    {
        return [
            'modtrim', //modalitatea de trimitere a expeditiei
            'greutate', //greutatea totala a expeditiei (kg, cu doua zecimale)
            'pliccolet', //numarul total de pachete din componenta expeditiei
            's_inaltime', //suma tuturor inalaltimilor pachetelor
            's_latime', //suma tuturor latimilor pachetelor
            's_lungime', //suma tuturor lungimilor pachetelor
            'volum', //suma volumelor pachetelor
            'dest_tara', //numele tarii de destinatie
            'tipcontinut', //valorile document - 1 sau non-document - 2
            'km_ext' //numar kilometri exteriori la expditor
        ];
    }
}

