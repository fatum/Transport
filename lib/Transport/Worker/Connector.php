<?php

/**
 * Description of Provider
 *
 * @author fatum
 */
namespace Transport\Worker;
use Transport\Worker\Connector as Conn;

abstract class Connector
{
    /**
     * Automatic connect to Provider
     * 
     * @return  void
     */
    public function __construct()
    {
        $this->connect();
    }
    
    /**
     * Disconnect from Provider
     * 
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }
    
    /**
     *
     * @param   string                          $providerName
     * @return  Connector 
     */
    public static function factory($providerName)
    {
        $class = "Transport\\Worker\\Connector\\". ucfirst($providerName);
        if (!class_exists($class)) {
            throw new Conn\Exception("This provider does not exists..");
        }
        
        $provider = new $class();
        if (!$provider instanceof Multithreading_Worker_Connector) {
            throw new Conn\Exception("This provider does not instanceof Provider");
        }
        
        return $provider;
    }
    
    abstract function connect();
    
    
    abstract function disconnect();
    
    /**
     *  Add task to Provider
     */
    abstract function set();
    
    /**
     *  Get task from Provider
     */
    abstract function get();
}

?>
