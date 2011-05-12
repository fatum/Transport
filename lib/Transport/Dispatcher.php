<?php

/**
 * Description of Dispatcher
 *
 * @author fatum
 */
use Transport;

abstract class Dispatcher 
{
    /**
     *
     * @var Transport\Task
     */
    protected $_object;

    abstract function dispatch($data);
    
    public function getTask()
    {
        return $this->_object;
    }
}

?>
