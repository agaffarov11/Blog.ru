<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PostServiceFactory {

    public function __invoke(ContainerInterface $container) {
        return new PostService($container->get('doctrine.entity_manager.orm_default'));
    }
     

}
