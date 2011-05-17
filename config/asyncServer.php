<?php
return array(
    "server"    => array(
        "class"     => "Transport\\Server\\SocketAsync",
        "host"      => "localhost",
        "port"      => 1001
    ),
    "provider"  => "Transport\\Provider\\Socket",
    "logger"    => array(
        "class" => "Transport\\Logger\\File",
        "file"  => "/tmp/app.log",
        "verbose"=> true,
        "level" => \Transport\Logger::DEBUG
    ),    
);
?>
