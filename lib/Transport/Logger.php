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
    
    private $_messages;
    private $_logLevel = self::ACCESS;
    
    public function setLevel($level)
    {
        if (in_array($level, array(self::DEBUG, self::ACCESS))) {
            $this->_logLevel = $level;
        }
    }
    
    public function add($message)
    {
        $this->_messages[] = $message;
    }
    
    abstract function dump();
}

?>
