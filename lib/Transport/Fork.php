<?php

/**
 * Description of Thread
 *
 * @author fatum
 */
namespace Transport;

class Fork
{
    private $_pid = null;
    
    public $isChild = false;

    public function getPid()
    {
        return $this->_pid;
    }

    /**
     *
     * Fork current running process
     * with data
     *
     * @param   callable    $callback
     * @param   array       $data
     * @return  bool
     */
    public function init($callback = array(), $data = array())
    {
        $pid = pcntl_fork();

        if ($pid === -1) {
            # Error
            $this->_die( "Could not fork" );
        }
        elseif (!$pid) {
            $this->isChild = true;
            $this->_pid = posix_getpid();

            $this->_spawn();

            if (is_callable($callback)) {
                call_user_func_array($callback, array($data));
            }
            $this->_die( "Success!" );
        }
        else {
            
            # Parent
            pcntl_signal(SIGCHLD, SIG_IGN);
            return $pid;
        }
    }

    private function _spawn()
    {
        umask(0);
        chdir("/");
        if( posix_setsid() < 0) {
            exit(0);
        }
    }
}

?>
