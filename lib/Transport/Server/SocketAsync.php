<?php

/**
 * Description of SocketAsync
 *
 * @author fatum
 */
namespace Transport\Server;

class SocketAsync extends \Transport\Server
{
    const MAX_CONNECTION = 5;
    
    /**
     *
     * @var socket
     */
    private $_socket;
    
    /**
     *
     * @var array
     */
    private $_clients;
    
    public function start()
    {   
        $this->_clients = range(0, self::MAX_CONNECTION);
        $this->_socket  = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        
        $config         = $this->getConfig();
        $logger         = $this->getProvider()->getLogger();
        
        $bindRes = @socket_bind         ($this->_socket, $config["host"], $config["port"]);
        if (empty($bindRes)) {            
            throw new Exception("Cannot bind to socket: ". socket_strerror(socket_last_error()));
        }
        
        socket_listen       ($this->_socket);
        socket_set_nonblock ($this->_socket);
        
        do {
            $read = $this->select();
            
            if (in_array($this->_socket, $read)) {
                $this->accept();
            }
            
            $this->execute($read);
            $logger->dump();
        }
        while(true);
    }
    
    private function execute( &$read)
    {
        /**
         *  Try to execute command
         */
        foreach (range(0, self::MAX_CONNECTION) as $client) {
            $socket = &$this->_clients[$client];
            
            if (in_array($socket, $read)) {        
                $data = $this->read($socket);
                
                try {
                    $response = $this->handle($data);
                    $this->write($socket, $response);
                }
                catch (\Transport\Dispatcher\Exception $e) {
                    $this->write(
                         $socket,   
                         "Some error occured in dispatcher: ". 
                         $e->getMessage(). PHP_EOL);
                }
                catch (Task\Exception $e) {
                    $this->write(
                         $socket,   
                         "Some error occured in task: ". 
                         $e->getMessage(). PHP_EOL);
                }
                catch (Exception $e) {
                    $this->write($socket,
                         "Some error occured: ". 
                         $e->getMessage(). PHP_EOL);
                }
            }
        }
    }
    
    protected function handle(& $data)
    {
        return $this->getProvider()->handle($data);
    }

    private function select()
    {
        $read[0]  = $this->_socket;
        foreach (range(0, self::MAX_CONNECTION) as $client) {
            if (is_resource($this->_clients[$client])) {
                $read[$client+1] = $this->_clients[$client];
            }
        }
        
        socket_select($read, $writearray=null, $exceptarray=null, $tv_sec=null);
        return $read;
    }
    
    private function accept()
    {
        $logger = $this->getProvider()->getLogger();
        
        $logger->add("We accepting...");
        foreach (range(0, self::MAX_CONNECTION) as $client) {
            if (!is_resource($this->_clients[$client])) {
                $clientSocket = @socket_accept($this->_socket);

                if ($clientSocket) {
                    $logger->add("Accept client #". $client);
                    $this->_clients[$client] = $clientSocket;
                    $logger->add("After accept #". $client);
                }
                else {
                    break 1;
                }
            }
        }
    }    
    
    public function read( &$socket)
    {
        $input = socket_read( $socket, 1024);
        
        if ($input == null) {
            $this->shutdown();
        }
        
        return $input;
    }
    
    public function write( &$socket, $data)
    {
        if ($data) {
            if (!is_string($data)) {
                $data = serialize($data);
            }
        
            socket_write($socket, $data);
        }
    }
    
    public function shutdown()
    {
        foreach ($this->_clients as $client) {
            if (is_resource($client)) {
                @socket_close($client);
            }
        }
        
        @socket_close($this->_socket);
        exit(0);
    }
}

?>
