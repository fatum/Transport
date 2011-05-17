<?php

/**
 * Description of Socket
 *
 * @author fatum
 */
namespace   Transport\Provider;
use         Transport\Server,
            Transport\Dispatcher,
            Transport\Task;

class Socket extends \Transport\Provider
{    
    public function handle($string)
    {
        $dispatcher = new Dispatcher\TextProtocol($string);
        $task       = $dispatcher->getTask();
        
        $this->getLogger()->add("We handle task: ". get_class($task));
    }
}

?>
