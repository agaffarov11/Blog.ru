<?php

declare(strict_types=1);

namespace Admin\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\PostService;

class DeletePostHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeletePostHandler
    {
        return new DeletePostHandler($container->get(TemplateRendererInterface::class),$container->get(PostService::class));
    }
}
