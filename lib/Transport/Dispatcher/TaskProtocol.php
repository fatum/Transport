r<?php

/**
 * Description of TaskProtocol
 *
 * @author fatum
 */
namespace Transport\Dispatcher;
use Transport\Task;

class TaskProtocol extends \Transport\Dispatcher
{
    /**
     * Input data
     * 
     * @param string $string
     */
    public function __construct($string)
    {
        $this->dispatch($string);
    }

    public function dispatch($data)
    {
        $task = unserialize($data);
        
        if (!$task instanceof Task) {
            throw new Task\Exception("Task does not instance of Transport\Task");
        }
        
        $this->setTask($task);
    }
}

?>
