<?php

declare(strict_types=1);

namespace Admin\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Service\PostService;

class PostListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostListHandler
    {
        return new PostListHandler($container->get(TemplateRendererInterface::class),$container->get(PostService::class));
    }
}
