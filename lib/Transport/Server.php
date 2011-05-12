<?php

/**
 * Description of Server
 *
 * @author fatum
 */
namespace Transport;

abstract class Server
{
    protected $_config;    
    protected $_provider;

    public function __construct(Config $config)
    {        
        foreach ($config as $method => $options) {
            if (method_exists($this, $method)) {
                
                $this->$method($options);
                unset($config[$method]);
            }
        }
        
        $this->setConfig($config);
    }
    
    public static function loadClass($server)
    {
        $class = "Transport\\Server\\". ucfirst($server);
        return new $class();
    }

    public function setProvider($provider)
    {
        if ($provider instanceof Provider) {
            $this->_provider = $provider;
        }
        else {
            $this->_provider = Provider::loadProvider($provider);
        }
    }
    
    public function getProvider()
    {
        return $this->_provider;
    }
    
    public function __destruct()
    {
        $this->shutdown();
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig(Config $config)
    {
        $this->_config;
    }
    
    public function checkMemoryLimit()
    {
        
    }
    
    public function garbageCollect()
    {
        if (gc_enabled() == false) {
            gc_enable();
        }
        
        gc_collect_cycles();
    }
    
    /**
     *  Start-stop server
     */
    abstract function start();
    abstract function shutdown();
    
    abstract function read  ( &$socket);
    abstract function write ( &$socket, $data);
}

?>
