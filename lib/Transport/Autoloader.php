<?php

/**
 * Description of Autoloader
 *
 * @author fatum
 */
namespace Transport;

class Autoloader
{
    /**
     * @var string
     */
    private $_includePath;

    /**
     * Register autoloader in autoloader stack
     */
    public function __construct()
    {
        $this->_includePath = realpath(dirname(__FILE__) . '/../');
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Resolve class name to file name.
     *
     * @param string $class
     */
    public function autoload($class)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        $filename = $this->_includePath . DIRECTORY_SEPARATOR . $file;
        
        if (is_readable($filename)) {
            include $filename;
        }
    }
}

?>
