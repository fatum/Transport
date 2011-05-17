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
        
        foreach ($this->_messages as $message) {
            $message .= $message.PHP_EOL;
        }
        
        $filename = $this->getFile();
        if (empty($filename)) {
            throw new Exception("You need set file for logging!");
        }
        
        $res = @file_put_contents($filename, $message, FILE_APPEND);
        if (!$res) {
            throw new Exception("Can't write to file: ". $filename);
        }
    }
}

?>
