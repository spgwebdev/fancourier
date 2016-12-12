<?php

namespace SeniorProgramming\FanCourier\Core;

interface EndpointInterface {
    
    public function set($params);
    
    public function fetchResults();
    
    public function validate($params);
}

