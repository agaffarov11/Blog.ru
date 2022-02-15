<?php
namespace Authorization\InputFilter;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RegInputFilterFactory implements FactoryInterface {
   
    public function __invoke(ContainerInterface $container)
    {
        return new RegInputFilter();
    }
    
}

