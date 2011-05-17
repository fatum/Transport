<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Transport;

class Application 
{
    protected $_config;
    protected $_server;
    protected $_provider;
    protected $_logger;

    public function __construct(Config $config)
    {
        foreach ($config as $method => $options) {
            $methodName = "set".ucfirst($method);
            
            if (method_exists($this, $methodName)) {
                $this->$methodName($options);
            }
        }
        
        $this->setConfig($config);
    }
    
    public function runWorker()
    {
        
    }
    
    public function runServer()
    {
        $server     = $this->getServer();
        $provider   = $this->getProvider();
        $logger     = $this->getLogger();
        
        $provider->setLogger($logger);
        $server->setProvider($provider);
        
        /**
         *  Dispatch server
         */
        $server->start();
    }
    
    public function setLogger($config)
    {
        $logger         = new $config["class"]($config);
        $this->_logger  = $logger;
    }
    
    public function getLogger()
    {
        return $this->_logger;
    }
    
    public function setProvider($provider)
    {
        $this->_provider = Provider::loadProvider($provider);
    }
    
    public function getProvider()
    {
        return $this->_provider;
    }
    
    public function setServer($server)
    {
        $this->_server = Server::loadClass($server["class"], $server);
    }
    
    public function getServer()
    {
        return $this->_server;
    }
    
    public function setConfig($config)
    {
        $this->_config = $config;
    }
    
    public function getConfig()
    {
        return $this->_config;
    }
}
?>
