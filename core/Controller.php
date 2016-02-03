<?php

namespace core;

use core\Utility as U;

class Controller
{

    protected $config = array();
    
    public function __construct()
    {
        $configFile = U::$APP.'config.php';
        if(file_exists($configFile)){
            $config = array();
            require_once $configFile;
            $this->config = $config;
        }
    }

}
