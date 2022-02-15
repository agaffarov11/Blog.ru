<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Mezzio\Authentication\UserInterface;
class UserServiceFactory {

    public function __invoke(ContainerInterface $container) {
        $user = $container->get(UserInterface::class);
        return new UserService($container->get('doctrine.entity_manager.orm_default'),$user);
    }
}