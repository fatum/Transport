<?php

/**
 * Description of Logger
 *
 * @author fatum
 */
namespace Transport;

abstract class Logger
{
    const DEBUG     = 1;
    const ACCESS    = 2;
    
    protected   $_messages;
    private     $_logLevel = self::ACCESS;
    private     $_verbose;
    
    public function __construct($config)
    {
        foreach ($config as $method => $options) {
            $methodName = "set".ucfirst($method);
            
            if (method_exists($this, $methodName)) {
                $this->$methodName($options);
            }
        }
    }
    
    public function setLevel($level)
    {
        if (in_array($level, array(self::DEBUG, self::ACCESS))) {
            $this->_logLevel = $level;
        }
    }
    
    public function setVerbose($value)
    {
        $this->_verbose = (bool) $value;
    }
    
    public function getVerbose()
    {
        return $this->_verbose;
    }
    
    public function add($message)
    {
        $this->_messages[] = $message;
    }
    
    abstract function dump();
}

?>
