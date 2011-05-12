<?php
return array(
    "server"    => "Transport\\Server\\AsyncServer",
    "provider"  => "Transport\\Provider\\",
    "logger"    => array(
        "class" => "Transport\\Logger\\Filer",
        "path"  => "/tmp/app.log"
    ),
    "host"      => "localhost",
    "port"      => 1000
    
);
?>
