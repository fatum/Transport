<?php

/**
 * Description of Dispatcher
 *
 * @author fatum
 */
namespace Transport;

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
    
    protected function getCommandClass($command, array $args)
    {
        $commandClass = "Transport\\Task\\". ucfirst($command);
        
        if (!class_exists($commandClass)) {
            throw new Exception("This command '$command' does not found..");
        }
        
        $object = new $commandClass($args);
        if (!$object instanceof \Transport\Task) {
            throw new Exception("This object '".  get_class($object)."' does not instance of Task..");
        }
        
        return $object;
    }
}

?>
