<?php

namespace App\Service;

use Psr\Container\ContainerInterface;


class CommentServiceFactory {

    public function __invoke(ContainerInterface $container) {
        return new CommentService($container->get('doctrine.entity_manager.orm_default'));

    }
}