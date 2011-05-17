<?php

/**
 * Description of Provider
 *
 * @author fatum
 */
namespace Transport;

abstract class Provider
{
    protected $_logger;
    
    public function setLogger(\Transport\Logger $logger)
    {
        $this->_logger = $logger;
    }
    
    public function & getLogger()
    {
        return $this->_logger;
    }
    
    /**
     * Try load provider class
     * 
     * @param   string  $provider
     */
    public static function loadProvider($provider)
    {
        if (strstr($provider, "Transport\\")) {
            $class = $provider;
        }else{
            $class = "Transport\\Provider\\". ucfirst($provider);
        }
        return new $class();
    }

    abstract function handle($string);
}

?>
