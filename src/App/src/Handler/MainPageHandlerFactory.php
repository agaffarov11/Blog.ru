<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Mezzio\Helper\UrlHelper;
use Mezzio\Helper\ServerUrlHelper;
use App\Service\CategoryService;
use App\Service\PostService;


class MainPageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : MainPageHandler
    {
        $container->get(ServerUrlHelper::class);
        return new MainPageHandler($container->get(TemplateRendererInterface::class),$container->get(PostService::class),
        $container->get(CategoryService::class));
    }
}
