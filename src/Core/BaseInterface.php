<?php

namespace SeniorProgramming\FanCourier\Core;

interface BaseInterface {
    
    public function instantiate ($class);
    
    public function makeRequest($credentials, $object);
}
