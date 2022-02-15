<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\UserService;

class AccountHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountHandler
    {
        return new AccountHandler($container->get(TemplateRendererInterface::class),$container->get(UserService::class));
    }
}
