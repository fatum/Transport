<?php

/**
 * Description of Task
 *
 * @author fatum
 */
namespace Transport;

abstract class Task
{
    /**
     *
     * @var Multithreading_Server_Request
     */
    private $_args;
    
    /**
     *
     * @var Multithreading_Server
     */
    protected $_server;
    
    /**
     *
     * @param Server_Request $request 
     */
    public function __construct(array $args)
    {
        $this->_args = $args;
    }
    
    public function setServer(Server &$server)
    {
        $this->_server = $server;
    }
    
    /**
     *
     * @return type 
     */
    public function & getServer()
    {
        return $this->_server;
    }
    
    abstract function execute();
}

?>
