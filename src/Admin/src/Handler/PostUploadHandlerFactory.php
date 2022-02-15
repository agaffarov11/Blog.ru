<?php

declare(strict_types=1);

namespace Admin\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Admin\InputFilter\PostInputFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use App\Service\CategoryService;
use App\Service\PostService;

class PostUploadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostUploadHandler
    {
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(PostInputFilter::class);
        return new PostUploadHandler($container->get(TemplateRendererInterface::class),$inputFilter,
    $container->get(CategoryService::class),$container->get(PostService::class));
    }
}
