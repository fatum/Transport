<?php

/**
 * Description of Config
 *
 * @author fatum
 */
namespace Transport;

class Config extends \ArrayObject
{
    public function __set($key, $value)
    {
        $this[$key] = $value;
        
        return $this;
    }
    
    public function __get($key)
    {
        return $this[$key];
    }
    
    public static function loadConfig($config)
    {
        $file           = TRANSPORT_ROOT . "/config/" . $config;
        $configArray    = include $file;
        
        $o =  new self($configArray);
        return $o;
    }
}

?>
