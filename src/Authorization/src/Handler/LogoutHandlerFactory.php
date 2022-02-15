<?php

declare(strict_types=1);

namespace Authorization\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\UserService;

class LogoutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LogoutHandler
    {
        return new LogoutHandler($container->get(TemplateRendererInterface::class),$container->get(UserService::class),$container->get('config'));
    }
}
