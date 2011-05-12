<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Transport;

class Cli 
{
    public function provider($providerName, $config)
    {
        $providerClass = "Transport\\Provider\\". ucfirst($providerName);
        
        if (!class_exists($providerClass)) {
            throw new \Transport\Exception("This provider '$providerClass' does not exists");
        }
        
        $object = new $providerClass();
        if (!$object instanceof \Transport\Provider) {
            throw new \Transport\Exception("This provider '".  get_class($object)."' does not instance of Provider");
        }
        
        $config = Config::loadConfig($config);
        $object->init($config);
    }
}
?>
