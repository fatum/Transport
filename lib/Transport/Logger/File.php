<?php

/**
 * Description of File
 *
 * @author fatum
 */
namespace Transport\Logger;

class File extends \Transport\Logger
{
    protected $_filename;
    
    public function setFile($filename)
    {
        $this->_filename = $filename;
    }
    
    public function getFile()
    {
        return $this->_filename;
    }

    /**
     * After cycle we dump messages to file
     */
    public function dump()
    {
        $messages = "";
        
        foreach ($this->_messages as $key => $message) {
            $messages .= $message.PHP_EOL;
            unset($this->_messages[$key]);
        }
                
        $filename = $this->getFile();
        if (empty($filename)) {
            throw new Exception("You need set file for logging!");
        }
        
        if (!is_writable($filename)) {
            throw new Exception("Log file is not writable: ". $filename);
        }
        
        file_put_contents($filename, $messages, FILE_APPEND);
        
        if ($this->getVerbose()) {
            echo $messages;
        }
    }
}

?>
