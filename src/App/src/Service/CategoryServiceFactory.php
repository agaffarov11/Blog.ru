<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


class CategoryServiceFactory {

    public function __invoke(ContainerInterface $container) {
        return new CategoryService($container->get('doctrine.entity_manager.orm_default'));
    }


    
}