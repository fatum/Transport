<?php

/**
 * Description of TextProtocol
 *
 * @author fatum
 */
namespace   Transport\Dispatcher;

class TextProtocol extends \Transport\Dispatcher
{
    public function __construct($string)
    {
        $this->dispatch($string);
    }
    
    public function dispatch($data)
    {
        if (!is_scalar($data)) {
            throw new Exception("Data must be scalar: $data");
        }
        
        $data = str_replace(array("\n","\r"), "", trim($data));
        $coms = @explode(" ", $data);
        
        if (empty($coms) && empty($data)) {
            throw new Exception("Empty result!");
        }
        
        if (isset($coms[0]) && isset($coms[1])) {
            $command    = $coms[0];
            $arg        = $coms[1];
        }
        else {
            $command    = $data;
            $arg        = null;
        }
        
        $task           = $this->getCommandClass($command, array($arg));
        $this->setTask($task);
    }
}

?>
